var TeamSpeakClient = require('node-teamspeak');
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var readline = require('readline');
var fs = require('fs');
var config = {};
var tsglob = {};

config.locked = false;

config.bannedWords = [
	"anne", "inngur", "gore",
	"dead", "gay", "tinyurl", "tiny.cc",
	"goo.gl", "is.gd", "bitly", "ow.ly",
	"bit.do", "app.x.co", "miniurl.com",
	"tr.im", "shortn.me", "Annie",
	"umbris.jpearce.net", ".li/pics/", "whip",
	"akk.li", "harryjames", "2guys", "lolhello.com",
	"cock", "blowjob", "Blowjob", "wormgush", "bottleguy",
	"1pitcher", "lemonparty", "nobrain", "fruitlauncher.com",
	"goatse", "merryholidays.org", "vomit", "selfpwn",
	"3guys1hammer", "painolympics", "phonejapan.com",
	"bowlgirl", "jarsquatter", "tubgirl", "specialfriedrice",
	"bluewaffle", "blue-waffle", "blue_waffle", "mikeisgod",
	"bestshockers", "goat.cx", "meatspin", ">", "<", "%3C"
]

config.formatters = [
	"[URL]",
	"[/URL]"
]

config.commandUrls = {
	alias: {
		land: "/landing",
		uwot: "http://www.youtube.com/embed/NsZMbs5PC64?autoplay=1",
		bear: "http://www.youtube.com/embed/OYa3V7GIizI?autoplay=1",
		op: "http://www.quickmeme.com/img/df/dff1ce4c0e8a2e6e66d87122d13298caf965537af1fa132d940faee5843af56d.jpg",
		ofcom: "http://www.ofcom.org.uk/static/spectrum/fat.html"
	},
	malias: {
		yt: {
			liq: "https://www.youtube.com/embed/Iwh5yOMmyFM?autoplay=1",
			freefall: "https://www.youtube.com/embed/ielnIal0694?autoplay=1",
			worlds: "https://www.youtube.com/embed/PqVkCC1O4Hs?autoplay=1"
		}
	},
	callback: {
		'help': printHelp,
		'mb': musicBot,
		'c': cmdConfig,
		'snow': cmdSnow
	}
}

config.musicBotUrl = "helix.interoth.com";

config.loginInfo = {
   client_login_name: 'serveradmin',
   client_login_password: 'lole'
}

tsglob.mutex = true;
tsglob.introBotID = 1;

cl = new TeamSpeakClient('helix.interoth.com');
global.cl = cl;
cl.send('login', config.loginInfo, function() {
	cl.send('use', {sid: 1}, function(err, response) {
		cl.send('servernotifyregister', {event: 'textserver'});
		cl.send('servernotifyregister', {event: 'channel', id: 0});
		console.log("Connected to ServerQuery");
	});
});

function stripArr(thestr, array, confirm) {
	found = false;
	array.forEach(function(i){
		if(thestr.indexOf(i) != -1) {
			thestr = thestr.replace(i, '');
			found = true;
		}
	});
	thestr = (confirm == true) ? ((found == true) ? thestr : false) : thestr;
	return thestr;
}

function doesContain(haystack, needle) {
	if(haystack.indexOf(needle) != -1) {
		return true;
	}
	return false;
}

function mbSend(cmdstr) {
	var client = require('http');
	var options = {
	    host: config.musicBotUrl,
	    port: 8080,
	    path: "/requests/status.xml?command=" + cmdstr,
	   	auth: ":watervapour"
	};
	client.get(options, function(res){
		console.log(res.statuscode);
	});
}

cl.on('clientmoved', function(data) {
	if(tsglob.mutex) {
		tsglob.mutex = false;
		return false;
	} else {
		tsglob.mutex = true;
	}
	console.log(data);
	cl.send('clientlist', {}, function(err, response) {
		for (i=0;i<response.length;i++) {
			client = response[i];

			cl.send('clientfind', {pattern: 'Intro'}, function(err, response) {
				if(response) {
					tsglob.introBotID = response.clid;
				} else {
					reply("ERROR: No Intro Bot!");
				}
			});

			if(client.clid == tsglob.introBotID) {
				if(client.cid == data.ctid) {
					cl.send('clientinfo', {clid: data.clid}, function(err, response) {
						uid = response.client_unique_identifier;
						for(theUser in config.users) {
							theUser = config.users[theUser];
							if(theUser.uid == uid && theUser.enabled == true) {
								io.emit('url', {user: response.client_nickname, url: theUser.intro});
							}
						}
					});
				}
			}
		}
	});
});

cl.on('textmessage', function(data) {
	console.log(data);

	user = false;
	for(theUser in config.users) {
		theUser = config.users[theUser];
		if(theUser.uid == data.invokeruid) {
			user = theUser;
		}
	}

	if(!user || user.enabled != true) {
		return false;
	}

	if(config.locked) {
		if(user.level < 2) {
			return false;
		}
	}

	if(data.msg.indexOf('[URL]') != -1 && data.msg.indexOf('!') == -1) {
		safeUrl = data.msg;
		safeUrl = stripArr(safeUrl, config.formatters, true);
		safeUrl = decodeURI(safeUrl);
		if(safeUrl.indexOf("youtube.com") != -1) {
			safeUrl = safeUrl.replace("youtube.com/watch?v=", "youtube.com/embed/");
			if(safeUrl.indexOf("?") != -1) {
				safeUrl = safeUrl + "&autoplay=1";
			} else {
				safeUrl = safeUrl + "?autoplay=1";
			}
		}
		isBlocked = false;
		safeUrl = (stripArr(safeUrl, config.bannedWords, true) == false) ? safeUrl : (isBlocked = true, '</a><b>HOOPLA</b>');
		if(safeUrl.indexOf("%") != -1) {
			safeUrl = '</a><b>HOOPLA</b>';
			isBlocked = true;
		}
		io.emit('url', {user: data.invokername, url: safeUrl, blocked: isBlocked});
		console.log(data.invokername + ": " + safeUrl);
	}
	if(data.msg.indexOf('!') != -1) {
		args = data.msg.split(" ");
		for(cmd in config.commandUrls['alias']) {
			if(args[0] == ("!" + cmd)) {
				io.emit('url', {user: data.invokername, url: config.commandUrls['alias'][cmd]});
			}
		}
		for(cmd in config.commandUrls['malias']) {
			if(args[0] == ("!" + cmd)) {
				for(arg in cmd) {
					if(arg == args[1]) {
						theArg = args[1];
						io.emit('url', {user: data.invokername, url: config.commandUrls['malias'][theArg]});
					}
				}
			}
		}
		for(cmd in config.commandUrls['callback']) {
			if(args[0] == ("!" + cmd)) {
				config.commandUrls['callback'][cmd](cl, args, user);
			}
		}
	}
});

cl.on('error', function(data) {
	console.log(data);
	console.log('Disconnected from ServerQuery');
});

cl.on('close', function(data) {
	console.log(data);
	console.log('Disconnected from ServerQuery');
});

function rehash() {
	fs.readFile(__dirname + '/tsmon.json', function (err, data) {
		if (err) {
			throw err; 
		}
		config.users = JSON.parse(data.toString());
	});
}

function writeUsers() {
	var fs = require('fs');
	fs.writeFile(__dirname + '/tsmon.json', JSON.stringify(config.users,undefined,3), function(err) {
	    if(err) {
	        console.log(err);
	    } else {
	        console.log("Config Updated!");
	    }
	});
}

function reply(message) {
	global.cl.send('gm', { msg: message });
}

function printHelp(cl) {
	cl.send('gm', {msg: "![land|uwot|bear|op|help] yt[liq|freefall|worlds] mb[pp(play/pause)|stop|vol(volume)] c[add|del|ban|intro|lock]"});
}

function musicBot(cl, args, user) {
	mbCmd = stripArr(args[1], config.formatters, false);
	console.log(mbCmd);
	if(doesContain(mbCmd, 'youtube')) {
		mbSend("in_play&input=" + encodeURIComponent(mbCmd));
		return true;
	}
	if(mbCmd == "pp") {
		mbSend("pl_pause");
	}
	if(mbCmd == "stop") {
		mbSend("pl_stop");
	}
	if(mbCmd == "vol") {
		mbSend("volume&val=" + parseInt(args[2]));
	}
}

function cmdConfig(cl, args, user) {
	if(user.level < 2) {
		return false;
	}
	cmd = args[1];
	if(cmd == "lock") {
		config.locked = !config.locked;
		reply("tslock: " + config.locked);
	}
	if(cmd == "ban") {
		if(!config.users[args[2]]) {
			reply("User not found!");
			return false;
		}
		if(config.users[args[2]].level > user.level) {
			reply("gr8 b8 4 h8 m8");
			return false;
		}
		user = config.users[args[2]];
		user.enabled = !user.enabled;
		reply("enabled = " + user.enabled);
		writeUsers();
	}
	if(cmd == "rehash") {
		rehash();
		reply("Rehash Complete");
		return true;
	}
	if(cmd == "add") {
		if(user.level < 2) {
			return false;
		}
		if(!args[2] || !args[3]) {
			reply("Usage: !c add <user> <ts name>");
			return false;
		}
		target = args[2];
		uname = args[3];
		if(config.users[target]) {
			reply("User exists!");
			return false;
		}
		cl.send('clientfind', {pattern: uname}, function(err, response) {
			if(response) {
				cl.send('clientinfo', {clid: response.clid}, function(err, response) {
					tuid = response.client_unique_identifier;
					for(theUser in config.users){
						theUser = config.users[theUser];
						if(theUser.uid == tuid) {
							reply("UID exists!");
							return false;
						}
					}
					config.users[target] = {};
					config.users[target].uid = tuid;
					config.users[target].enabled = true;
					config.users[target].level = 1;
					writeUsers();
					reply("User '" + target + "' added with ID " + tuid);
				});
			} else {
				reply("Client not found!");
			}
		});
	}
	if(cmd == "del") {
		if(user.level < 2) {
			return false;
		}
		if(!args[2]) {
			reply("Usage: !c del <user>");
			return false;
		}
		user = args[2];
		if(config.users[user]) {
			delete config.users[user];
			writeUsers();
			reply("User '" + user + "' deleted!");
		} else {
			reply("User not found!");
		}
	}
	if(cmd == "info") {
		if(!args[2]) {
			reply("Usage: !c info <user>");
			return false;
		}
		user = args[2];
		if(!config.users[user]) {
			reply("User not found!");
			return false;
		}
		reply(JSON.stringify(config.users[user]));
	}
	if(cmd == "intro") {
		setIntro(cl, args, user);
	}
}

function setIntro(cl, args, user) {
	console.log(args);
	target = config.users[args[2]];
	if(!args[2]) {
		reply("Usage: !c intro <user> [<url>]");
		return false;
	}
	if(!args[3]) {
		args[3] = "";
	}
	url = stripArr(args[3], config.formatters, true);
	if(target) {
		target.intro = url;
		reply("intro = " + target.intro);
		writeUsers();
	}
}

var snowCfg = {
	on: false,
	interval: 5000,
	state: false,
	a: '-*-*- Happy Christmas -*-*-',
	b: '*-*-* Happy Christmas *-*-*',
	timer: {}
}

function cmdSnow(cl, args, user) {
	if(user.level < 2) {
			return false;
	}
	if(!args[1]) {
		reply("Usage: !snow <on|off|interval|seta|setb> [<a|b|interval(ms)>]");
	}
	cmd = args[1];
	if(cmd == 'on') {
		snowSet();
	}
	if(cmd == 'off') {
		clearInterval(snowCfg.timer);
	}
	if(cmd == 'interval') {
		snowCfg.interval = args[2];
		clearInterval(snowCfg.timer);
		snowSet();
	}
	if(cmd == 'seta') {
		args.splice(0,2);
		snowCfg.a = args.join(' ');
		clearInterval(snowCfg.timer);
		snowSet();
	}
	if(cmd == 'setb') {
		args.splice(0,2);
		snowCfg.b = args.join(' ');
		clearInterval(snowCfg.timer);
		snowSet();
	}
}

function snowSet() {
	snowCfg.timer = setInterval(function(){
		if(snowCfg.state) {
			name = snowCfg.a;
		} else {
			name = snowCfg.b;
		}
		snowCfg.state = !snowCfg.state;
		cl.send('channeledit', {cid: 283, channel_name: '[cspacer0]' + name});
	}, snowCfg.interval);
}

app.get('/', function(req, res){
  res.sendfile('index.html');
});

app.get('/landing', function(req, res){
  res.sendfile('landing.html');
});

app.get('/blocked', function(req, res){
  res.sendfile('blocked.html');
  console.log('Site Blocked');
});

app.get('/bandegy', function(req, res){
  res.sendfile('blocked.html');
	cl.send('clientfind', {pattern: 'Deg'}, function(err, response) {
		if(response) {
			cl.send('banclient', {clid: response.clid, time: 10, banreason: "Voice Ban"}, function(err, response) {
				reply("Degy banned!");
			});
		} else {
			reply("Client not found!");
		}
  	});
});

app.get('/ban', function(req, res){
  theUser = req.param('user');
  if(req.ip == '86.173.88.5') {
    theUser = 'Interoth';
  }
	if(!theUser || !req.param('len')) {
		res.send({response: 'missingparam'});
		return false;
	}
	if(req.param('camcheck')) {

	}
	cl.send('clientfind', {pattern: theUser}, function(err, response) {
		if(response) {
			cl.send('banclient', {clid: response.clid, time: req.param('len'), banreason: "API Ban"}, function(err, resp) {
				res.send({response: 'success', clid: response.clid});
				console.log(resp);
			});
		} else {
			res.send({response: 'notfound'});
		}
	});
});

app.get('/play', function(req, res){
  if(!req.param('src')) {
    res.send({response: 'missingparam'});
    return false;
  }
  theUrl = req.param('src');
  //if(req.ip == '86.183.87.174') {
  	//theUrl = 'http://translate.google.com/translate_tts?tl=ja&q=James';
  //}
  io.emit('url', {user: req.ip, url: theUrl});
  res.send({response: 'success'});
});

app.get('/johncena', function(req, res){
  res.sendfile('blocked.html');
  io.emit('url', {user: config.users.james, url: config.users.james.intro});
});

io.on('connection', function(socket){
  console.log('a user connected');
});

http.listen(9001, function(){
	console.log('listening on *:9001');
});

var rl = readline.createInterface({
	input: process.stdin,
	output: process.stdout
});

rl.on('line', function(cmd){
	global.cl.send('gm', {msg: cmd});
});

setInterval(function(){
	global.cl.send('keepalive');
}, 10000);

rehash();
