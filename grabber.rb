require 'rubygems'
require 'mechanize'
require 'open-uri'
require 'mysql'
require 'json'

HOSTNAME = "localhost"
DATABASE = "songs"
USERNAME = "songs_user"
PASSWORD = "songs_pass"
ROOT_URL = "http://www.songmeanings.net"
DB = Mysql.new(HOSTNAME,USERNAME,PASSWORD,DATABASE)

def fetch_songs
  @mech = Mechanize.new

  index_url = ARGV.first || "#{ROOT_URL}/artist/view/songs/137438965436/"

  puts "Working on #{index_url}..."

  begin
    page = @mech.get(index_url)
  rescue Exception => e
    puts "Unable to fetch #{index_url}, #{e}"
    exit
  end

  song_table = page.search("//div[@id='detailed_artists']/table").first rescue nil

  unless song_table
    puts "no table of songs was found"
    exit
  end

  songs = {
    # title => url
  }

  # all but the first header tr
  song_table.search("//tr")[1..-1].each do |row| 
    anchor = row.search("a").first
    songs[anchor.inner_text] = anchor['href']
  end

  puts "Found #{songs.size} songs"

  songs.each do |title,url|
    url = "#{ROOT_URL}#{url}"
  
    res = DB.query("SELECT id FROM songs WHERE url = '#{url}'")
  
    if res && res.num_rows > 0
      puts "Already have lyrics for #{url}"
      next
    end
  
    puts "Fetching #{url}"
  
    page = @mech.get url
    lyrics = page.search("//div[@id='songText2']").inner_text
    query = "INSERT INTO songs (`title`,`url`,`lyrics`) VALUES (?,?,?)"
    qry = DB.prepare query
    qry.execute title,url,lyrics
    qry.close
  end
end

def clean_songs
  DB.query("SELECT lyrics,id FROM songs").each do |song|
    id      = song.last
    lyrics  = song.first

    if lyrics["$(document).ready"]
      lyrics = lyrics.split("\n")[3..-1].join("\n")
    else
      next
    end
    
    query = "UPDATE songs SET lyrics=? WHERE id=?"
    qry = DB.prepare query
    qry.execute lyrics,id
    qry.close
  end
end

def word_freq
  words = {}
  songs = {
  }
  
  (res = DB.query("SELECT lyrics,id,title FROM songs")).each do |row|
    yt = "https://gdata.youtube.com/feeds/api/videos?q=The+National+#{row.last.split(" ").join("+")}&key=AI39si7PG-52co_mjvnCcTWYAxnMbmLgXcldn6BoIWxMV9SbX36EtgK7SDZsk4qbAnEK_Gz3kh5RXJbTu76C4KFLmGu3AouQ3g&alt=json"
    youtube_url = JSON.parse(open(yt).read)['feed']['entry'][0]['link'].last['href'].split("/").last

    row.first.gsub(/[\n]+/," ").gsub(/[\.,!\[\]\?\(\)]/,"").split("---").first.downcase.split(" ").each do |word|
      next if word.size < 4
      if words[word]
        words[word] = words[word] + 1
      else
        words[word] = 1
      end
    end
    
    songs[row.last] = {
      :youtube => youtube_url,
      :lyrics => row.first.gsub(/[\n]+/,"<br />").split("---").first
    }
    
  end
  
  output = {
    :song_count => res.num_rows,
    :word_count => words.size,
    :songs => songs,
    :words => words
  }
  
#  output = "The National uses #{words.size} unique words in #{song_count} songs, that's a whopping #{words.size/song_count} words per song"
#  output += "<table><THEAD><tr><td>Word</td><td>Count</td></tr></THEAD><TBODY>"
  
#  words.sort_by { |k,v| v }.each do |word,count|
#    output += "<tr><td>#{word}</td><td>#{count}</td></tr>"
#  end
  
#  output += "</TBODY></table>"
  
  File.open("public/js/report.js","w") do |f|
    f.write "var report = #{output.to_json};"
  end
  
end

#fetch_songs
#clean_songs
word_freq