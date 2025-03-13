import {Howl} from 'howler';

let chatContainer, messageInput,
	messageButton, fileButton, fileInput, audioButton, currentSound = null, inputRange, mPlayer, mPlay, mPause,
	mDuration;

$(function () {
	mPlayer = document.getElementById('player');
	mPlay = document.getElementById('play');
	mPause = document.getElementById('pause');
	inputRange = document.getElementById('seek');
	mDuration = document.getElementById('duration');

	mPlay.addEventListener('click', function () {
		if (!currentSound) {
			return;
		}
		currentSound.play();
		this.classList.add('d-none');
		mPause.classList.remove('d-none');
	});

	mPause.addEventListener('click', function () {
		if (!currentSound) {
			return;
		}
		currentSound.pause();
		this.classList.add('d-none');
		mPlay.classList.remove('d-none');
	});

	inputRange.addEventListener('input', function () {
		if (!currentSound) {
			return;
		}
		currentSound.seek(this.value);
		// handleInputRange();
	});

	$('[data-play-audio="true"]').on('click', function () {
		const src = $(this).attr('data-src');

		if (currentSound !== null && currentSound !== undefined) {
			currentSound.stop();
		}

		currentSound = new Howl({
			src: [src],
			html5: true,
			onload: function () {
				mPlayer.classList.add('open');
				inputRange.max = currentSound.duration();
				inputRange.value = 0;
				handleInputRange();
			},
			onplay: function () {
				requestAnimationFrame(step.bind(this));
			},
			onseek: function () {
				requestAnimationFrame(step.bind(this));
			},
			onend: function () {
				mPlayer.classList.remove('open');
				mDuration.innerText = '00:00';
			}
		});
		currentSound.play();
	});

	const messages = document.getElementById('messages');
	const messagesScroll = new PerfectScrollbar(messages, {
		wheelPropagation: true,
	});

	messages.scrollTop = messages.scrollHeight;
});

function step() {
	let self = this;

	let seek = currentSound.seek() || 0;
	mDuration.innerText = formatTime(seek);
	inputRange.value = seek;
	handleInputRange();

	if (currentSound.playing()) {
		requestAnimationFrame(step.bind(self));
	}
}

function handleInputRange() {
	const min = inputRange.min;
	const max = inputRange.max;
	const val = inputRange.value;
	let percentage = (val - min) * 100 / (max - min);
	inputRange.style.backgroundSize = percentage + '% 100%';
}

function formatTime (secs) {
	var minutes = Math.floor(secs / 60) || 0;
	var seconds = Math.floor(secs - minutes * 60) || 0;

	return (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
}