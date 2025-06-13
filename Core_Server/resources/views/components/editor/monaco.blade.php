<div>

<div id="monaco-editor" style="height:400px;border:1px solid #ccc;"></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('monaco-editor');
    if (el) {
        monaco.editor.create(el, {
            language: 'json',
            theme: 'vs-dark'
        });
    }
});
</script>

</div>