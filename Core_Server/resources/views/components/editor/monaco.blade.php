<div>

<div id="monaco-editor" style="height:400px;border:1px solid #ccc;"></div>

<script>
  var ClientIDToColor = []
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

    provider.awareness.setLocalStateField('email', 'user@example.com')
    provider.awareness.setLocalStateField('color', 'red')

    const monacoBinding = new Ymocano.MonacoBinding(ytext, (editor.getModel()), new Set([editor]), provider.awareness)
    const styleElement = document.createElement('style')
    document.head.appendChild(styleElement)

   provider.awareness.on('update', () => {
    provider.awareness.getStates().forEach((state, clientId) => {
        if(ClientIDToColor[clientId] ! == null){
            ClientIDToColor[clientId] = generateRandomColor()
            const color = ClientIDToColor[clientId]
            styleElement.innerHTML += `
                    .yRemoteSelection-${userId} {
                        background-color: ${color}50;
                    }
                    .yRemoteSelectionHead-${userId} {
                        border-left: 2px solid ${color};
                    }
                    `
        }
        })
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
        .yRemoteSelection {
            background-color: rgb(250, 129, 0, .5)
        }
        .yRemoteSelectionHead {
            position: absolute;
            border-left: orange solid 2px;
            border-top: orange solid 2px;
            border-bottom: orange solid 2px;
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