<div>

<div id="monaco-editor" style="height:400px;border:1px solid #ccc;"></div>

<script>
  var ClientIDToColor = []
  var EditorsData = []
  var currentEditors = []
document.addEventListener('DOMContentLoaded', () => {
  const ydoc = new Y.Doc()
  const ytext = ydoc.getText('monaco')
  const room = `monaco-demo-${new Date().toLocaleDateString('en-CA')}`

  provider = Ysc.createYjsProvider(ydoc, room, 'http://localhost:9090/y-sweet-auth')

    const el = document.getElementById('monaco-editor');
    if (el) {
        editor = monaco.editor.create(el, {
            language: 'json',
            theme: 'vs-dark'
        });
    }

    provider.awareness.setLocalStateField('name', 'Paulhenry')
    provider.awareness.setLocalStateField('color', generateRandomColor())

    const monacoBinding = new Ymocano.MonacoBinding(ytext, (editor.getModel()), new Set([editor]), provider.awareness)
    const styleElement = document.createElement('style')
    document.head.appendChild(styleElement)

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

</div>