dynamic class org.iCPPSTeam.iCP.iCPLoader {
	public var HOST:String    = '173.230.148.252';
	public var PENGUIN:Object = 'Not found yet';
	
	public var REPLACES:Array = new Array();
	public var FAKE_LANG:Object = {};
	
	public var HANDLERS:Object = {};
	public var SHAREVARS:Object = {};
	public var HANDLERVARS:Object = {};
	

	
	public function iCPLoader(arg:String) {
		this.HANDLERS['SHELL']         = {};
		this.HANDLERS['AIRTOWER']      = {};
		this.HANDLERS['LOCAL_CRUMBS']  = {};
		this.HANDLERS['GLOBAL_CRUMBS'] = {};
		
		this.HANDLERS['ENGINE']    = {};
		this.HANDLERS['INTERFACE'] = {};
		
		this.FAKE_LANG['Your Suggested Servers'] = 'Welcome To iCPPS';
		
		this._addReplace(function(url:String) : String {
			if(url == 'CORE') return 'http://icpps.com/Files/Server/Core.swf';
			return url;
		});
		
		_global.baseURL = 'http://play.clubpenguin.com/';
		
		System.security.allowDomain('*');
		loadMovie('http://media1.clubpenguin.com/play/v2/client/load.swf?connectionID=cp1756', 1);


		_root.onEnterFrame = function() {
			for(var i:String in _level1) if(typeof _level1[i] == 'movieclip') {
				_level1.bootLoader.messageFromAS3({
					type: 'setEnvironmentData',
					data: {
						clientPath: 'http://media1.clubpenguin.com/play/v2/client/',
						contentPath: 'http://media1.clubpenguin.com/play/v2/content/',
						gamesPath: 'http://media1.clubpenguin.com/play/v2/games/',
						connectionID: 'cp1756',
						language: 'en',
						basePath: '',
						affiliateID: '0',
						playPath: "http://play.clubpenguin.com"
					}
				});
				_root.onEnterFrame = function() {
					if(_level1.shellContainer.DEPENDENCIES_FILENAME) _level0.CLIENT.handleContainerFound(_level0.CLIENT.PENGUIN = _level1.shellContainer);
				};
			}
		};
	}
	
	public function handleContainerFound(container:Object) : Void {
		_global.PenguBackup = container;
		with(container) {
			_level1.bootLoader.messageFromAS3({type: 'showLogin'});
			if(LOCAL_CRUMBS) _level0.CLIENT._fireEvent('LOCAL_CRUMBS');
			if(GLOBAL_CRUMBS) _level0.CLIENT._fireEvent('GLOBAL_CRUMBS');
			if(AIRTOWER) _level0.CLIENT._fireEvent('AIRTOWER');
			if(SHELL) _level0.CLIENT._fireEvent('SHELL');
			
			if(!LOCAL_CRUMBS) return;
			for(var i:String in this.FAKE_LANG) LOCAL_CRUMBS.lang[i] = this.FAKE_LANG[i];
			
			if(!GLOBAL_CRUMBS or !AIRTOWER or !SHELL) return; //Wait till everything is loaded...
			
			SHELL.analytics = false;
			SHELL.hideErrorPrompt();
			
			GLOBAL_CRUMBS.login_server.ip        = this.HOST;
			GLOBAL_CRUMBS.login_server.even_port = 6112;
			GLOBAL_CRUMBS.login_server.odd_port  = 6112;
			GLOBAL_CRUMBS.redemption_server.ip   = this.HOST;
			GLOBAL_CRUMBS.redemption_server.port = 6113;
			// ---
			//GLOBAL_CRUMBS.game_crumbs.four.path = 'http://localhost/game.swf';
			//GLOBAL_CRUMBS.room_crumbs.town.path = 'http://localhost/mcOLD/room.swf';
			
			AIRTOWER.LOGIN_IP        = this.HOST;
			AIRTOWER.LOGIN_PORT_EVEN = 6112;
			AIRTOWER.LOGIN_PORT_ODD  = 6112;
			SHELL.redemption_server.ip   = this.HOST;
			SHELL.redemption_server.port = 6113;
			SHELL.world_crumbs = new Array();
			//SHELL.world_crumbs[101] = {id: 101, name: "Candy Mountain", ip: "109.169.56.130", port: "9875"};
			SHELL.world_crumbs[101] = {id: 101, name: "Minerva's Den", ip: "173.230.148.252", port: "9875"};
			LOCAL_CRUMBS.lang.chat_restrict = 'a-z A-Z z-A 0-9 !-} ?!.,;:`´-_/\\(){}=&$§"=€@\'*+-ßäöüÄÖÜ#<>\n\t';
		}
		
		_root.onEnterFrame = this.waitForInterface;
	}
	
	public function bakeHandler(handler:String) : Function {
		if(!_level0.CLIENT.HANDLERS[handler]) _level0.CLIENT.HANDLERS[handler] = {};
		return function(rObj:Array) : Void {
			_level0.CLIENT.HANDLERVARS = [];
			for(var i in rObj) _level0.CLIENT.HANDLERVARS[i] = rObj[i];
			for(var i in _level0.CLIENT.HANDLERS[handler]) _level0.CLIENT.HANDLERS[handler][i](_level0.CLIENT.HANDLERVARS);
		};
	}
	
	private function waitForInterface() : Void {
		with(_level0.CLIENT.PENGUIN) {
			if(INTERFACE) _level0.CLIENT._fireEvent('INTERFACE');
			if(ENGINE) _level0.CLIENT._fireEvent('ENGINE');
			
			if(!INTERFACE || !ENGINE) return; //Wait till the Interface is loaded...
			INTERFACE.DOCK.chat_mc.chat_input.maxChars = 96;
			INTERFACE.convertToSafeCase = function(txt:String) : String { return txt; };
			INTERFACE.isClickableLogItem = function() : Boolean { return true; };
			ENGINE.randomizeNearPosition = function(player, x, y, range) : Boolean {
				player.x = x;
				player.y = y;
				
				return true;
			};
		}
		for(var i:String in this.CLIENT.PLUGINS) if(this.CLIENT.PLUGINS[i][1]) this.CLIENT.PLUGINS[i][0]();
		
		delete this.onEnterFrame;
		delete _root.onEnterFrame;
	}
	
	
	////////////////////////////
	//... Client Functions ...//
	////////////////////////////
	
	public function _fireEvent(evtName:String) {
		for(var i in _level0.CLIENT.HANDLERS[evtName]) _level0.CLIENT.HANDLERS[evtName][i]();
		_level0.CLIENT.HANDLERS[evtName] = {};
	}
	
	public function _airtowerHandler(handler:String) {
		return this.PENGUIN.AIRTOWER.addListener(handler, this.bakeHandler(handler));
	}
	


	public function _call(array:Array, a, b, c, d, e, f, g, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z) {
		var object = this.PENGUIN;
		for(var i = 0; i < array.length; i++) {
			if(array.length == i + 1) return object[array[i]](a, b, c, d, e, f, g, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z);
			object = object[array[i]];
		}
	}
	
	public function _makeCallback(shareVar:String) {
		var original = this.SHAREVARS[shareVar]
		this.SHAREVARS[shareVar] = function(a,b,c,d,e,f,g,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z) { return original(a,b,c,d,e,f,g,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z); };
	}
	
	public function _callWithShareVars(array:Array, a, b, c, d, e, f, g, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z) {
		a = this.SHAREVARS[a];
		b = this.SHAREVARS[b];
		c = this.SHAREVARS[c];
		d = this.SHAREVARS[d];
		e = this.SHAREVARS[e];
		f = this.SHAREVARS[f];
		g = this.SHAREVARS[g];
		h = this.SHAREVARS[h];
		i = this.SHAREVARS[i];
		j = this.SHAREVARS[j];
		k = this.SHAREVARS[k];
		l = this.SHAREVARS[l];
		m = this.SHAREVARS[m];
		n = this.SHAREVARS[n];
		o = this.SHAREVARS[o];
		p = this.SHAREVARS[p];
		q = this.SHAREVARS[q];
		r = this.SHAREVARS[r];
		s = this.SHAREVARS[s];
		t = this.SHAREVARS[t];
		u = this.SHAREVARS[u];
		v = this.SHAREVARS[v];
		w = this.SHAREVARS[w];
		x = this.SHAREVARS[x];
		y = this.SHAREVARS[y];
		z = this.SHAREVARS[z];
		
		return this._call(array, a, b, c, d, e, f, g, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z);
	}
	
	public function _callBase(array:Array, a, b, c, d, e, f, g, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z) {
		return this._useBase(this._call(array, a, b, c, d, e, f, g, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z));
	}
	
	private	function secretForeach(object, level, a) {
		var retVal = {};
		for(var i in object) {
			if((typeof object[i] == 'object' || a) && level != 0) retVal[i] = secretForeach(object[i], level - 1);
			else retVal[i] = object[i];
		}
		return retVal;
	}

	function _delete(array:Array) : Void {
		var object = this.PENGUIN;
		for(var i = 0; i < array.length; i++) {
			if(array.length == i + 1) delete object[array[i]];
			object = object[array[i]];
		}
	}

	function _setTimeout(cmd:String, interval:Number) : Void {
		this.PENGUIN.setTimeout(cmd, interval);
	}

	function _useBase(base) {
		return this.PENGUIN = base;
	}

	function _restoreBase() {
		return this.PENGUIN = _global.PenguBackup;
	}
	

	var loader:MovieClipLoader;
	function _initLoader() : MovieClipLoader {
		_level0.CLIENT.loader = new MovieClipLoader();
		_level0.CLIENT.loader.addListener({onLoadInit: this.dumbHandler, onLoadError: this.dumbHandler, onLoadProgress: this.dumbHandler, onLoadStart: this.dumbHandler, onLoadComplete: this.dumbHandler});
 	 
 	 return _level0.CLIENT.loader;
	}
	
	function _addReplace(func:Function) : Number {
		var id:Number = this.REPLACES.length;
		this.REPLACES[id] = func;
		return id;
	}
	
	function _removeReplace(id) : Void {
		if(this.REPLACES[id]) delete(this.REPLACES[id]);
		else for(var i:String in this.REPLACES) if(this.REPLACES[i] == id) delete(this.REPLACES[i]);
	}

	function dumbHandler(mc:MovieClip) { _level0.CLIENT.PENGUIN.LAST_EVENT_MC = mc; }
}