<div>

<div id="monaco-editor" style="height:400px;border:1px solid #ccc;"></div>

<script>
  var currentEditors = []
  async function authenticate(docId, token) {
    const response = await fetch('http://localhost:9090/y-sweet-auth', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ docId, token })
    });

    if (!response.ok) {
        throw new Error('Authentication failed');
    }

    return await response.json();
}

document.addEventListener('DOMContentLoaded', () => {
  const ydoc = new Y.Doc()
  const ytext = ydoc.getText('monaco')
  const room = `monaco-demo-${new Date().toLocaleDateString('en-CA')}`

  provider = Ysc.createYjsProvider(ydoc, room, authenticate(room, {{auth()->user()->token}}))

    const el = document.getElementById('monaco-editor');
    if (el) {
        editor = monaco.editor.create(el, {
            language: 'json',
            theme: 'vs-dark'
        });
    }

    provider.awareness.setLocalStateField('name', '{{auth()->user()->name}}')
    provider.awareness.setLocalStateField('color', generateRandomColor())

    const monacoBinding = new Ymocano.MonacoBinding(ytext, (editor.getModel()), new Set([editor]), provider.awareness)
    const styleElement = document.getElementById('monaco-style')

   provider.awareness.on('change', () => {
        if(Array.from(provider.awareness.getStates().keys()).sort().toString() !== Array.from(currentEditors.keys()).sort().toString() ){
            console.log(Array.from(provider.awareness.getStates().keys()))
            currentEditors = []

            provider.awareness.getStates().forEach((state, clientId) => {

                currentEditors[clientId] = state.name
                styleElement.innerHTML += `
                            .yRemoteSelection-${clientId} {
                                background-color: ${state.color}50;
                            }
                            .yRemoteSelectionHead-${clientId} {
                                border-left: ${state.color} solid 2px;
                                border-top: ${state.color} solid 2px;
                                border-bottom: ${state.color} solid 2px;
                            }
                            `
            })
        }
    })
});

function generateRandomColor() {
        return `#${Math.floor(Math.random() * 16777215).toString(16)}`
        }

</script>

    <style>
        #monaco-editor {
            width:100%;
            height:600px;
            border:1px solid #ccc;
        }
        .yRemoteSelectionHead {
            position: absolute;
            height: 100%;
            box-sizing: border-box;
        }
        .yRemoteSelectionHead::after {
            position: absolute;
            content: ' ';
            border: 3px solid orange;
            border-radius: 4px;
            left: -4px;
            top: -5px;
        }
    </style>
    <style id='monaco-style'>
    </style>

</div>