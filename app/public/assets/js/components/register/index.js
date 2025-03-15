$(function () {
	let validator = $('form.needs-validation').jbvalidator({
		errorMessage: true,
		successClass: true,
		language: config.assetUrl + 'assets/vendor/libs/jbvalidator/lang/fa.json'
	});
});