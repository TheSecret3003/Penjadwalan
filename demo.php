<h2>Demo</h2>
<style>
    table {
  border-collapse: collapse;
}

td {
  border: 1px gray solid;
  padding: 4px;
  width: 5em;
}
</style>
<button id="export">Export</button> Click to open table in Microsoft Word
<div id="docx">
  <div class="WordSection1">
    <table>
      <tr>
        <td>A1</td>
        <td>B1</td>
        <td>C1</td>
        <td>E1</td>
      </tr>
      <tr>
        <td>A2</td>
        <td>B2</td>
        <td>C2</td>
        <td>E2</td>
      </tr>
      <tr>
        <td>A3</td>
        <td>B3</td>
        <td>C3</td>
        <td>E3</td>
      </tr>
      <tr>
        <td>A4</td>
        <td>B4</td>
        <td>C4</td>
        <td>E4</td>
      </tr>
    </table>
  </div>
</div>
<script>
    window.export.onclick = function() {
 
 if (!window.Blob) {
    alert('Your legacy browser does not support this action.');
    return;
 }

 var html, link, blob, url, css;
 
 // EU A4 use: size: 841.95pt 595.35pt;
 // US Letter use: size:11.0in 8.5in;
 
 css = (
   '<style>' +
   '@page WordSection1{size: 841.95pt 595.35pt;mso-page-orientation: landscape;}' +
   'div.WordSection1 {page: WordSection1;}' +
   'table{border-collapse:collapse;}td{border:1px gray solid;width:5em;padding:2px;}'+
   '</style>'
 );
 
 html = window.docx.innerHTML;
 blob = new Blob(['\ufeff', css + html], {
   type: 'application/msword'
 });
 url = URL.createObjectURL(blob);
 link = document.createElement('A');
 link.href = url;
 // Set default file name. 
 // Word will append file extension - do not add an extension here.
 link.download = 'jadwal';   
 document.body.appendChild(link);
 if (navigator.msSaveOrOpenBlob ) navigator.msSaveOrOpenBlob( blob, 'jadwal.doc'); // IE10-11
         else link.click();  // other browsers
 document.body.removeChild(link);
};
    
</script>