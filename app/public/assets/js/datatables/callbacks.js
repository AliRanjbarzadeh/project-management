"use strict";

function rowActionDone(isSuccess, message) {
	if (isSuccess) {
		toastSuccess(message);
		redrawDatatable();
	} else {
		toastError(message);
	}
}

function redrawDatatable(param = 'page') {
	if (typeof getDataTable === 'function') {
		if (param === 'full') {
			param = true;
			let order = sessionStorage.getItem(getDataTable().settings()[0].sTableId + 'Sort');
			if (order) {
				getDataTable().order(JSON.parse(order));
			}
		}
		getDataTable().draw(param);
	}
}