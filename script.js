/*
  SearchTable
  version 0.1 alpha
  22nd October 2010
  Robert Henjes, http://www.rhenjes.de

  22 Okt 2010


  Code partly copied from: http://www.vonloesch.de/node/23
  Thanks to many, many people for contributions and suggestions.
*/

searchtable = {
  filtersingle: function(term, _id, cellNr) {
        var suche = term.value.toLowerCase();
        var table = searchtable.getTableByID(_id);
        var ele;
        for (var r = 1; r < table.rows.length; r++){
                ele = table.rows[r].cells[cellNr].innerHTML.replace(/<[^>]+>/g,"");
                if (ele.toLowerCase().indexOf(suche)>=0 )
                        table.rows[r].style.display = '';
                else table.rows[r].style.display = 'none';
        }
  },

  filterwords: function(phrase, _id) {
        var words = phrase.value.toLowerCase().split(" ");
        var table = searchtable.getTableByID(_id);
        var ele;
        for (var r = 1; r < table.rows.length; r++){
                ele = table.rows[r].innerHTML.replace(/<[^>]+>/g,"");
                var displayStyle = 'none';
                for (var i = 0; i < words.length; i++) {
                    if (ele.toLowerCase().indexOf(words[i])>=0)
                        displayStyle = '';
                    else {
                        displayStyle = 'none';
                        break;
                    }
                }
                table.rows[r].style.display = displayStyle;
        }
  },

  filterall: function(term, _id) {
        var searchstr = term.value.toLowerCase();
        var table = searchtable.getTableByID(_id);
        var ele;
        for (var r = 1; r < table.rows.length; r++){
                ele = table.rows[r].innerHTML.replace(/<[^>]+>/g,"");
                var displayStyle = 'none';
                if (ele.toLowerCase().indexOf(searchstr)>=0)
                        displayStyle = '';
                else displayStyle = 'none';
                table.rows[r].style.display = displayStyle;
        }
  },

  getTableByID: function(_id) {
        var _table = document.getElementById(_id).getElementsByTagName('table')[0];
        return _table;
  },

};
