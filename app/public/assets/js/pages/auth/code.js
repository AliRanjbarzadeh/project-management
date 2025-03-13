import {Timer} from 'easytimer.js';
import axios from "axios";

$(function () {
	const timer = new Timer();

	const txtTimerText = document.getElementById('timerText');
	const btnSendAgain = document.getElementById('sendAgain');

	timer.addEventListener('secondsUpdated', (e) => {
		//update ui
		let minutes = timer.getTimeValues().minutes;
		let seconds = timer.getTimeValues().seconds;

		let timerText = `0${minutes}:${seconds}`;
		if (seconds < 10) {
			timerText = `0${minutes}:0${seconds}`;
		}

		txtTimerText.innerText = __('verify.sentences.timer', {time: timerText});
	});

	timer.addEventListener('stopped', (e) => {
		txtTimerText.classList.add('d-none');
		btnSendAgain.classList.remove('d-none');
	});

	timer.start({
		countdown: true,
		startValues: {
			seconds: 120
		}
	});

	btnSendAgain.addEventListener('click', (e) => {
		txtTimerText.innerText = __('verify.sentences.timer', {time: '02:00'});
		btnSendAgain.classList.add('d-none');
		txtTimerText.classList.remove('d-none');
		timer.reset();

		axios.post(route('admin.auth.code.resend'), {}).then((response) => {
			const res = response.data;
			if (res.success) {
				toastr.success(res.message);
			} else {
				btnSendAgain.classList.remove('d-none');
				txtTimerText.classList.add('d-none');
				toastr.error(res.message);
			}
		}).catch((error) => {
			console.error(error);
		});
	});
});