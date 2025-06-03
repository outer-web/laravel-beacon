<script defer>
	class Beacon {
		pageViewsEnabled = false;
		pageViewCaptureInterval = null;
		pageViewEventUuid = null;
		pageViewStartedAt = null;
		previouslySentPageViewTime = 0;
		captureUrl = '{{ route('beacon.api.capture') }}';

		constructor() {
			this.pageViewsEnabled = false;
			this.pageViewStartedAt = Date.now();
		}

		init() {
			if (this.pageViewsEnabled) {
				this.captureInitialPageView();
				this.periodicallyAppendPageView();
				this.handlePageViewOnVisibilityChange();
			}
		}

		enablePageViews() {
			this.pageViewsEnabled = true;
		}

		captureInitialPageView() {
			this.log('Capturing initial page view');

			this.capture(
					'page_view',
					'Page View', {
						title: document.title,
						duration_in_seconds: 0,
						referrer: document.referrer,
					},
					window.BeaconConfig?.events?.page_view?.custom_properties || {})
				.then(response => {
					if (response.data && response.data.uuid) {
						this.pageViewEventUuid = response.data.uuid;
					}

					this.log('Initial page view captured', this.pageViewEventUuid);
				})
				.catch(error => {
					this.log('Error capturing initial page view', error);
				});
		}

		periodicallyAppendPageView() {
			this.pageViewCaptureInterval = setInterval(() => {
				if (!this.pageViewsEnabled || !this.pageViewEventUuid) {
					this.log('Page view capture interval cleared');
					clearInterval(this.pageViewCaptureInterval);
					return;
				}

				this.log('Appending to page view capture', this.pageViewEventUuid);

				this.appendPageViewCapture();
			}, window.BeaconConfig?.events?.page_view?.interval || 30000);
		}

		handlePageViewOnVisibilityChange() {
			document.addEventListener("visibilitychange", () => {
				if (!this.pageViewsEnabled || !this.pageViewEventUuid) {
					return;
				}

				if (document.visibilityState === "hidden") {
					this.log('Appending page view capture on visibility change', this.pageViewEventUuid);

					this.appendPageViewCapture();

					clearInterval(this.pageViewCaptureInterval);
				} else {
					this.log('Visibility changed, resetting page view start time');

					this.pageViewStartedAt = Date.now();
					this.periodicallyAppendPageView();
				}
			});
		}

		appendPageViewCapture() {
			const timeSpent = Math.floor((Date.now() - this.pageViewStartedAt) / 1000);

			this.appendToCapture(
				this.pageViewEventUuid, {
					title: document.title,
					duration_in_seconds: timeSpent + this.previouslySentPageViewTime,
					referrer: document.referrer,
				},
				window.BeaconConfig?.events?.page_view?.custom_properties || {}
			);

			this.previouslySentPageViewTime += timeSpent;
			this.pageViewStartedAt = Date.now();
		}

		capture(type, label, properties = {}, customProperties = {}) {
			this.log('Capturing Beacon event', type, label, properties, customProperties);

			return fetch(this.captureUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						type: type,
						label: label,
						properties: properties,
						custom_properties: customProperties,
					}),
				})
				.then(response => {
					if (!response.ok) {
						throw new Error('Could not capture Beacon event');
					}

					return response.json();
				})
				.catch(error => {
					console.error('Could not capture Beacon event');
				});
		}

		appendToCapture(eventUuid, properties = {}, customProperties = {}) {
			this.log('Appending to Beacon capture event using fetch', eventUuid, properties, customProperties);

			return fetch(`${this.captureUrl}/${eventUuid}`, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						properties: properties,
						custom_properties: customProperties,
					}),
				})
				.then(response => {
					if (!response.ok) {
						throw new Error('Could not append to Beacon capture event');
					}

					return response.json();
				})
				.catch(error => {
					this.log('Could not append to Beacon capture event', error);
				});
		}

		log(...args) {
			@if ($debug)
				console.log(`Beacon: ${args[0]}`, ...args.slice(1));
			@endif
		}
	}

	(() => {
		window.Beacon = new Beacon();

		@if ($capturePageViews)
			window.Beacon.enablePageViews();
		@endif

		window.Beacon.init();
	})();
</script>
