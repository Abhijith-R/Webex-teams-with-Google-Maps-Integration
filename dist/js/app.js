
// Declare some globals that we'll need throughout
let activeCall, spark;

// There's a few different events that'll let us know we should initialize
// CiscoSpark and start listening for incoming calls, so we'll wrap a few things
// up in a function.
function connect() {
  if (!spark) {
    spark = ciscospark.init({
      config: {
        phone: {
          // Turn on group calling; there's a few minor breaking changes with
          // regards to how single-party calling works (hence, the opt-in), but
          // this is how things are going to work in 2.0 and if you plan on
          // doing any group calls, you'll need this turned on for your entire
          // app anyway.
          enableExperimentalGroupCallingSupport: true
        }
      },
      credentials: {
        access_token: "Your Access Token"
      }
    });
  }

  if (!spark.phone.registered) {
    // we want to start listening for incoming calls *before* registering with
    // the cloud so that we can join any calls that may already be in progress.
    spark.phone.on('call:incoming', (call) => {
      Promise.resolve()
        .then(() => {
          // Let's render the name of the person calling us. Note that calls
          // from external sources (some SIP URIs, PSTN numbers, etc) may not
          // have personIds, so we can't assume that field will exist.
          if (call.from && call.from.personId) {
            // In production, you'll want to cache this so you don't have to do
            // a fetch on every incoming call.
            return spark.people.get(call.from.personId);
          }

          return Promise.resolve();
        })
        .then((person) => {
          const str = person ? `Anwser incoming call from ${person.displayName}` : 'Answer incoming call';
          if (confirm(str)) {
            call.answer();
            bindCallEvents(call);
          }
          else {
            call.decline();
          }
        })
        .catch((err) => {
          console.error(err);
          alert(err);
        });
    });

    return spark.phone.register()
      .then(() => {
        document.body.classList.add('listening');
      })
}

  return Promise.resolve();
}

function bindCallEvents(call) {
  activeCall = call;

  call.on('error', (err) => {
    console.error(err);
    alert(err.stack);
  });

  // We can start rendering local and remote video before the call is
  // officially connected but not right when it's dialed, so we'll need to
  // listen for the streams to become available. We'll use `.once` instead
  // of `.on` because those streams will not change for the duration of
  // the call and it's one less event handler to worry about later.

  call.once('localMediaStream:change', () => {
    document.getElementById('self-view').srcObject = call.localMediaStream;
  });

  call.on('remoteMediaStream:change', () => {
    // Ok, yea, this is a little weird. There's a Chrome behavior that prevents
    // audio from playing from a video tag if there is no corresponding video
    // track.
    [
      'audio',
      'video'
    ].forEach((kind) => {
      if (call.remoteMediaStream) {
        const track = call.remoteMediaStream.getTracks().find((t) => t.kind === kind);
        if (track) {
          document.getElementById(`remote-view-${kind}`).srcObject = new MediaStream([track]);
        }
      }
    });
  });

  // Once the call ends, we'll want to clean up our UI a bit
  call.on('inactive', () => {
    // Remove the streams from the UI elements
    document.getElementById('self-view').srcObject = undefined;
    document.getElementById('remote-view-audio').srcObject = undefined;
    document.getElementById('remote-view-video').srcObject = undefined;

    // And unset the call object
    activeCall = undefined;
  });

  call.on('change:sendingAudio', () => {
    //document.getElementById('camera-state').innerHTML = call.sendingAudio ? 'on' : 'off';
  });

  call.on('change:sendingVideo', () => {
    //document.getElementById('microphone-state').innerHTML = call.sendingVideo ? 'on' : 'off';
  });
}

// In order to simplify the state management needed to keep track of our button
// handlers, we'll rely on the current call global object and only hook up event
// handlers once.

document.getElementById('hangup').addEventListener('click', () => {
  if (activeCall) {
    activeCall.hangup();
  }
});

document.getElementById('start-sending-audio').addEventListener('click', () => {
  if (activeCall) {
    activeCall.startSendingAudio();
  }
});

document.getElementById('stop-sending-audio').addEventListener('click', () => {
  if (activeCall) {
    activeCall.stopSendingAudio();
  }
});

document.getElementById('start-sending-video').addEventListener('click', () => {
  if (activeCall) {
    activeCall.startSendingVideo();
  }
});

document.getElementById('stop-sending-video').addEventListener('click', () => {
  if (activeCall) {
    activeCall.stopSendingVideo();
  }
});


  connect()
    .then(() => {
      const call = spark.phone.dial("someone@domain.com");

      // Call our helper function for binding events to calls
      bindCallEvents(call);
    });