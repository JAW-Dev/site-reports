/* global document */

// Import Modules.
import datePicker from './datePicker';
import clickHandler from './clickHandler';
import filterClickHandler from './filterClickHandler';

const hasDatePicker = (filters) => {
	for (const item of filters) {
		if (item.type === 'date') {
			return true;
		}
	}

	return;
}

const report = params => {
	// Bail if params are not set.
	if (typeof params === 'undefined' || params === null) {
		console.error('Action was not defined!'); // eslint-disable-line
		return false;
	}

	const targetId = `${params.slug}-report`;

	const filters = params.hasOwnProperty('filters') ? params.filters : [];

	if (hasDatePicker(filters)) {
		datePicker(targetId);
		filterClickHandler(targetId);
	}

	const target = targetId !== 'undefined' ? document.querySelector(`#${targetId}`) : null;
	clickHandler(target, params);
};



export default report;
