let allRoutes = JSON.parse('[{"name":"telescope","uri":"telescope%2F%7Bview%3F%7D"},{"name":"login","uri":"login"},{"name":"login.attempt","uri":"login"},{"name":"login.forgot-password.index","uri":"login%2Freset-password"},{"name":"login.forgot-password.attempt","uri":"login%2Freset-password"},{"name":"register.index","uri":"register"},{"name":"register.register","uri":"register"},{"name":"assets.translations","uri":"js%2Ftranslations.js"},{"name":"assets.router","uri":"js%2Frouter.js"},{"name":"storage.local","uri":"storage%2F%7Bpath%7D"}]');
window.route = function (name, parameters = null) {
	const r = allRoutes.find(x => x.name === name);
	if (parameters) {
		let uri = r.uri;
		for (const param of Object.keys(parameters)) {
			uri = uri.replace(new RegExp(encodeURIComponent('{' + param + '}'), 'g'), parameters[param]);
			uri = uri.replace(new RegExp(encodeURIComponent('{' + param + '?}'), 'g'), parameters[param]);
		}
		return baseUrl + decodeURIComponent(uri) + '/';
	} else {
		return baseUrl + decodeURIComponent(r.uri) + '/';
	}
}