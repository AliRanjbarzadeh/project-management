window.addEventListener('DOMContentLoaded', function () {
	const allPermissions = getAllPermissions();
	allPermissions.forEach(checkboxPermission => {
		checkboxPermission.addEventListener('change', function () {
			const categoryId = this.getAttribute('data-permission-category');
			const allPermissionsForCategory = Array.from(getAllPermissionsByCategory(categoryId));
			const allGrantedPermissionsForCategory = allPermissionsForCategory.filter(mCheckboxPermission => mCheckboxPermission.checked);
			const parentCategoryCheckbox = getParentPermission(categoryId);

			if (allGrantedPermissionsForCategory.length > 0) {
				parentCategoryCheckbox.indeterminate = allGrantedPermissionsForCategory.length < allPermissionsForCategory.length;
				if (allGrantedPermissionsForCategory.length === allPermissionsForCategory.length) {
					parentCategoryCheckbox.checked = true;
				}
			} else {
				parentCategoryCheckbox.indeterminate = false;
				parentCategoryCheckbox.checked = false;
			}
		});
	});

	document.querySelectorAll('[data-all-permissions]').forEach(function (checkAllElement) {
		checkAllElement.addEventListener('change', function () {
			const categoryId = checkAllElement.getAttribute('data-all-permissions');
			document.querySelectorAll(`[data-permission-category="${categoryId}"]`).forEach(function (checkboxElement) {
				checkboxElement.checked = checkAllElement.checked;
			});
		});
	});

	checkAllPermissions();
});

function getAllPermissions() {
	return document.querySelectorAll(`[data-permission-category]`);
}

function getAllPermissionsByCategory(categoryId) {
	return document.querySelectorAll(`[data-permission-category="${categoryId}"]`);
}

function getParentPermission(categoryId) {
	return document.querySelector(`[data-all-permissions="${categoryId}"]`);
}

function checkAllPermissions() {
	const allPermissions = getAllPermissions();
	for (let i = 0; i < allPermissions.length; i++) {
		const permissionElement = allPermissions[i];
		const categoryId = permissionElement.getAttribute('data-permission-category');
		const allPermissionsForCategory = Array.from(getAllPermissionsByCategory(categoryId));
		const allGrantedPermissionsForCategory = allPermissionsForCategory.filter(mCheckboxPermission => mCheckboxPermission.checked);
		const parentCategoryCheckbox = getParentPermission(categoryId);
		if (allGrantedPermissionsForCategory.length > 0) {
			parentCategoryCheckbox.indeterminate = allGrantedPermissionsForCategory.length < allPermissionsForCategory.length;
		}
	}
}