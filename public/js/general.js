//General JS

// Welcome to my playground.

function random_from(collection) {
	return collection[Math.floor(Math.random()*collection.length)];
}

function generate_verse() {
	var songs = new Array();
	for(var key in report['songs']) {
		songs.push(key);
	}
	
	// get 4 songs
	var used_songs = new Array();
	while(used_songs.length < 4) {
		var s = random_from(songs);
		while(jQuery.inArray(s,used_songs) >= 0) {
			s = random_from(songs);
		}
		used_songs.push(s);
	}
	
	var lines = [];
	// get 4 random lines from those 4 songs
	for(var i=0,len=used_songs.length;i<len;i++) {
		var song = used_songs[i];
		var lyrics = report['songs'][song]['lyrics'].split("<br />");
		var line = random_from(report['songs'][song]['lyrics'].split("<br />"));
		if(undefined == line || "" == line) {
			line = random_from(report['songs'][song]['lyrics'].split("<br />"));
		}
		lines.push(line);
	}

	$('#generated_song').html("<div class='alert alert-success'>"+lines.join("<br />")+"</div>");
}

function transform_playing(song_title) {
	html  = "<h2>"+song_title+"</h2>";
	html += '<iframe width="100%" height="315" src="http://www.youtube.com/embed/'+report['songs'][song_title]['youtube']+'" frameborder="0" allowfullscreen></iframe>';
	html += '<div class="lyrics">'+report['songs'][song_title]['lyrics']+'</div>';
	$('#playing').html(html);
}

function generate_page() {
	//console.log(report);
	var stats = "Analyzing <span style='font-size:20px'>" + report['song_count'] + "</span> songs by <span style='font-size:20px'><b>The National</b></span> yielded a total of <span style='font-size:20px'>" + report['word_count'] + "</span> words";
	stats += " or roughly <span style='font-size:20px'>" + parseInt(report['word_count']/report['song_count']) + "</span> words per song";
	$('#quick_stats').html(stats);

	songs = '';	
	for(var key in report['songs']) {
		songs += '<li><a class="song_title" href="#">' + key + '</a></li>';
	}
		
	$('#songs_analyzed').append(songs);

	$('.song_title').click(function(){
		
		transform_playing(this.innerHTML);
		
		$('a[href=#playing]').tab('show');
		
	});

	words = '';
	for(var key in report['words']) {
		words += "<tr><td>"+key+"</td><td>"+report['words'][key]+"</td></tr>";
	}
	
	$('#words > tbody:last').append(words);
	
	$("#words").tablesorter({
		sortList: [[1,1]]
	});
	
	if (typeof SELECTED_TAB !== 'undefined') {
	    // variable is undefined
			$('a[href=#'+SELECTED_TAB+']').tab('show');
	} else	{
		$('a[href=#generator]').tab('show');
	}
}