   /*
  *
  *  Credit to Terry Young on StackOverview 
  *  Export to CSV using jQuery and html
  *  http://stackoverflow.com/questions/16078544/export-to-csv-using-jquery-and-html
  *
  *  Modify the Jquery code for the Simple SKU Generator plugin to export SKU table from the database into CSV file. 
  *   - HP Gong 
  */

(function($) {
$(document).ready(function () {

function exportTableToCSV($table, filename) {

var $rows = $table.find('tr:has(td)'),

// Temporary delimiter characters unlikely to be typed by keyboard
// This is to avoid accidentally splitting the actual contents
tmpColDelim = String.fromCharCode(11), // vertical tab character
tmpRowDelim = String.fromCharCode(0), // null character

// actual delimiter characters for CSV format
colDelim = '","',
rowDelim = '"\r\n"',

// select all text from table into CSV formatted string
csv = '"' + $rows.map(function(a, row) {
var $row = $(row),
$cols = $row.find('td');

return $cols.map(function(b, col) {
var $col = $(col),
text = $col.text();

return text.replace(/"/g, '""'); // escape double quotes

}).get().join(tmpColDelim);

}).get().join(tmpRowDelim)
.split(tmpRowDelim).join(rowDelim)
.split(tmpColDelim).join(colDelim) + '"';

// Data URI
var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

// For IE (11)
if (window.navigator.msSaveOrOpenBlob) {
var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
type: "text/csv;charset=utf-8;"
});
navigator.msSaveBlob(blob, filename); 

// HTML5 Blob    
var blob = new Blob([csv], {
type: 'text/csv;charset=utf-8'
});
var csvUrl = URL.createObjectURL(blob);

$(this)
.attr({
'download': filename,
'href': csvUrl
});
} else {
// Data URI
var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

$(this)
.attr({
'download': filename,
'href': csvData,
'target': '_blank'
});
}
}

// This must be a hyperlink
$("#export").on('click', function(event) {
// CSV
var args = [$('#dvData>table'), 'woo_sku.csv'];

exportTableToCSV.apply(this, args);

// If CSV, don't do event.preventDefault() or return false
// We actually need this to be a typical hyperlink
});
});

})(jQuery);
