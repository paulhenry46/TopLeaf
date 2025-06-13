import './bootstrap';


import * as monaco from 'monaco-editor'
window.monaco = monaco;

import EditorWorker from 'monaco-editor/esm/vs/editor/editor.worker?worker';
import JsonWorker from 'monaco-editor/esm/vs/language/json/json.worker?worker';

// Tell Monaco where to find its workers (Vite ESM way)
window.MonacoEnvironment = {
    getWorker: function (moduleId, label) {
        switch (label) {
            case 'json':
                return new JsonWorker();
            default:
                return new EditorWorker();
        }
    }
};

import * as Y from 'yjs'
window.Y = Y;

import * as Ymocano from 'y-monaco'
window.Ymocano = Ymocano;

import * as Ysc from '@y-sweet/client'

window.Ysc = Ysc;