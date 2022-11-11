console.log('Admin Scripts Running...') // eslint-disable-line

import reports from '../../reports.json';
const reportsObj = JSON.parse(JSON.stringify(reports));

// Import Modules
import report from './modules/report';

for (const item in reportsObj) {
	report(reportsObj[item][0]);
}
