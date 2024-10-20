import { startStimulusApp } from '@symfony/stimulus-bridge';
import { Application } from '@hotwired/stimulus';

const application = startStimulusApp(require.context('./controllers', true, /\.js$/));
