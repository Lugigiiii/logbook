<?php
/* Smarty version 4.2.1, created on 2023-06-10 22:05:43
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\admin-users.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6484d797ab8984_53448876',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '09584e69dde19caf4f34b9fca6a907896c52f6cb' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\admin-users.tpl',
      1 => 1681935864,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin-sidebar.tpl' => 1,
    'file:admin-topbar.tpl' => 1,
  ),
),false)) {
function content_6484d797ab8984_53448876 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\resources\\php\\smarty-4.2.1\\libs\\plugins\\modifier.date_format.php','function'=>'smarty_modifier_date_format',),));
?>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php $_smarty_tpl->_subTemplateRender("file:admin-sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php $_smarty_tpl->_subTemplateRender("file:admin-topbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Benutzerverwaltung</h1>

                    <!-- DataTable -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Benutzer</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Benutzername</th>
                                            <th>E-Mail</th>
                                            <th>Erstellt</th>
                                            <th>Admin</th>
                                            <th>Aktiviert</th>
                                            <th>Kennwort</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'element');
$_smarty_tpl->tpl_vars['element']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['element']->value) {
$_smarty_tpl->tpl_vars['element']->do_else = false;
?>
                                        <tr>
                                            <td><?php echo $_smarty_tpl->tpl_vars['element']->value[1];?>
 <?php echo $_smarty_tpl->tpl_vars['element']->value[2];?>
</td>
                                            <td><?php echo $_smarty_tpl->tpl_vars['element']->value[3];?>
</td>
                                            <td><?php echo $_smarty_tpl->tpl_vars['element']->value[4];?>
</td>
                                            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['element']->value[5],"%d.%m.%Y");?>
</td>
                                            <?php if ($_smarty_tpl->tpl_vars['element']->value[6] == 1) {?>
                                                <td class="td-true"><a href="/resources/php/functions/main-functions.php?edit=true&user=<?php echo $_smarty_tpl->tpl_vars['element']->value[0];?>
&admin=0">Ja</a></td>
                                            <?php } else { ?>
                                                <td class="td-false"><a href="/resources/php/functions/main-functions.php?edit=true&user=<?php echo $_smarty_tpl->tpl_vars['element']->value[0];?>
&admin=1">Nein</a></td>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['element']->value[7] == 1) {?>
                                                <td class="td-true"><a href="/resources/php/functions/main-functions.php?edit=true&user=<?php echo $_smarty_tpl->tpl_vars['element']->value[0];?>
&active=0">Ja</a></td>
                                            <?php } else { ?>
                                                <td class="td-false"><a href="/resources/php/functions/main-functions.php?edit=true&user=<?php echo $_smarty_tpl->tpl_vars['element']->value[0];?>
&active=1">Nein</a></td>
                                            <?php }?>
                                            <td class="td-blue"><a href="/resources/php/functions/main-functions.php?edit=true&user=<?php echo $_smarty_tpl->tpl_vars['element']->value[0];?>
&reset=1">Reset</a></td>
                                        </tr>
                                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- add new car -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Benutzer erfassen</h6>
                        </div>
                        <div class="card-body">
                            <form method="post" action="/resources/php/functions/main-functions.php">
                                <div class="form-group">
                                  <label for="newUserFirst">Vorname</label>
                                  <input type="text" class="form-control" name="newUserFirst" id="newUserFirst" placeholder="Vorname eingeben" required>
                                </div>
                                <div class="form-group">
                                    <label for="newUserLast">Nachname</label>
                                    <input type="text" class="form-control" name="newUserLast" id="newUserLast" placeholder="Nachname eingeben" required>
                                  </div>
                                <div class="form-group">
                                  <label for="newUserName">Benutzername</label>
                                  <input type="text" class="form-control" name="newUserName" id="newUserName" placeholder="Benutzername eingeben" required>
                                </div>
                                <div class="form-group">
                                    <label for="newUserMail">E-Mail</label>
                                    <input type="email" class="form-control" name="newUserMail" id="newUserMail" placeholder="E-Mail eingeben" required>
                                  </div>
                                <div class="form-check">
                                  <input type="checkbox" class="form-check-input" name="newUserAdmin" id="newUserAdmin">
                                  <label class="form-check-label" for="newUserAdmin">Benutzer zur Gruppe Admin hinzufügen <br />(Erhält Zugriff zum Backend)<br /><br /></label>
                                </div>
                                <button type="submit" class="btn btn-primary">Erfassen</button>
                              </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sitzung beenden?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Abbrechen</button>
                    <button class="btn btn-primary" onclick="logOut()">Abmelden</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <?php echo '<script'; ?>
 src="../resources/vendor/jquery/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../resources/vendor/bootstrap/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>

    <!-- Core plugin JavaScript-->
    <?php echo '<script'; ?>
 src="../resources/vendor/jquery-easing/jquery.easing.min.js"><?php echo '</script'; ?>
>

    <!-- Custom scripts for all pages-->
    <?php echo '<script'; ?>
 src="../resources/js/sb-admin-2.min.js"><?php echo '</script'; ?>
>

    <!-- Page level plugins -->
    <?php echo '<script'; ?>
 src="../resources/vendor/datatables/jquery.dataTables.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../resources/vendor/datatables/dataTables.bootstrap4.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://cdn.datatables.net/datetime/1.4.0/js/dataTables.dateTime.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="../resources/js/main-functions.js"><?php echo '</script'; ?>
>

    
    <?php echo '<script'; ?>
>        
        $(document).ready( function () {
            $('#dataTable').DataTable({
                order: [[3, 'asc']],
                "language":{
                    "emptyTable": "Keine Daten in der Tabelle vorhanden",
                    "info": "_START_ bis _END_ von _TOTAL_ Einträgen",
                    "infoEmpty": "Keine Daten vorhanden",
                    "infoFiltered": "(gefiltert von _MAX_ Einträgen)",
                    "infoThousands": ".",
                    "loadingRecords": "Wird geladen ..",
                    "processing": "Bitte warten ..",
                    "paginate": {
                        "first": "Erste",
                        "next": "Nächste",
                        "last": "Letzte",
                        "previous": "Vorherige"
                    },
                    "aria": {
                        "sortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
                        "sortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                    },
                    "select": {
                        "rows": {
                            "_": "%d Zeilen ausgewählt",
                            "1": "1 Zeile ausgewählt"
                        },
                        "cells": {
                            "1": "1 Zelle ausgewählt",
                            "_": "%d Zellen ausgewählt"
                        },
                        "columns": {
                            "1": "1 Spalte ausgewählt",
                            "_": "%d Spalten ausgewählt"
                        }
                    },
                    "buttons": {
                        "print": "Drucken",
                        "copy": "Kopieren",
                        "copyTitle": "In Zwischenablage kopieren",
                        "copySuccess": {
                            "_": "%d Zeilen kopiert",
                            "1": "1 Zeile kopiert"
                        },
                        "collection": "Aktionen <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                        "colvis": "Spaltensichtbarkeit",
                        "colvisRestore": "Sichtbarkeit wiederherstellen",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Alle Zeilen anzeigen",
                            "1": "Zeige 1 Zeile",
                            "_": "Zeige %d Zeilen"
                        },
                        "pdf": "PDF",
                        "createState": "Ansicht erstellen",
                        "removeAllStates": "Alle Ansichten entfernen",
                        "removeState": "Entfernen",
                        "renameState": "Umbenennen",
                        "savedStates": "Gespeicherte Ansicht",
                        "stateRestore": "Ansicht %d",
                        "updateState": "Aktualisieren",
                        "copyKeys": "Drücken Sie die Taste <i>STRG<\/i> oder <i>⌘<\/i> + <i>C<\/i> um die Tabelle<br \/>in den Zwischenspeicher zu kopieren.<br \/><br \/>Um den Vorgang abzubrechen, klicken Sie die Nachricht an oder drücken Sie die Escape-Taste."
                    },
                    "autoFill": {
                        "cancel": "Abbrechen",
                        "fill": "Alle Zellen mit <i>%d<i> füllen<\/i><\/i>",
                        "fillHorizontal": "Alle horizontalen Zellen füllen",
                        "fillVertical": "Alle vertikalen Zellen füllen",
                        "info": "Automatische Vervollständigung"
                    },
                    "decimal": ",",
                    "search": "Suche:",
                    "searchBuilder": {
                        "add": "Bedingung hinzufügen",
                        "button": {
                            "0": "Such-Baukasten",
                            "_": "Such-Baukasten (%d)"
                        },
                        "condition": "Bedingung",
                        "conditions": {
                            "date": {
                                "after": "Nach",
                                "before": "Vor",
                                "between": "Zwischen",
                                "empty": "Leer",
                                "not": "Nicht",
                                "notBetween": "Nicht zwischen",
                                "notEmpty": "Nicht leer",
                                "equals": "Gleich"
                            },
                            "number": {
                                "between": "Zwischen",
                                "empty": "Leer",
                                "equals": "Entspricht",
                                "gt": "Größer als",
                                "gte": "Größer als oder gleich",
                                "lt": "Kleiner als",
                                "lte": "Kleiner als oder gleich",
                                "not": "Nicht",
                                "notBetween": "Nicht zwischen",
                                "notEmpty": "Nicht leer"
                            },
                            "string": {
                                "contains": "Beinhaltet",
                                "empty": "Leer",
                                "endsWith": "Endet mit",
                                "equals": "Entspricht",
                                "not": "Nicht",
                                "notEmpty": "Nicht leer",
                                "startsWith": "Startet mit",
                                "notContains": "enthält nicht",
                                "notStartsWith": "startet nicht mit",
                                "notEndsWith": "endet nicht mit"
                            },
                            "array": {
                                "equals": "ist gleich",
                                "empty": "ist leer",
                                "contains": "enthält",
                                "not": "ist ungleich",
                                "notEmpty": "ist nicht leer",
                                "without": "aber nicht"
                            }
                        },
                        "data": "Daten",
                        "deleteTitle": "Filterregel entfernen",
                        "leftTitle": "Äußere Kriterien",
                        "rightTitle": "Innere Kriterien",
                        "title": {
                            "0": "Such-Baukasten",
                            "_": "Such-Baukasten (%d)"
                        },
                        "value": "Wert",
                        "clearAll": "Alle entfernen",
                        "logicAnd": "Und",
                        "logicOr": "Oder"
                    },
                    "searchPanes": {
                        "clearMessage": "Leeren",
                        "collapse": {
                            "0": "Suchmasken",
                            "_": "Suchmasken (%d)"
                        },
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Keine Suchmasken",
                        "title": "Aktive Filter: %d",
                        "showMessage": "zeige Alle",
                        "collapseMessage": "Alle einklappen",
                        "count": "{total}",
                        "loadMessage": "Lade Suchmasken..."
                    },
                    "thousands": ".",
                    "zeroRecords": "Keine passenden Einträge gefunden",
                    "lengthMenu": "_MENU_ Zeilen anzeigen",
                    "datetime": {
                        "previous": "Vorher",
                        "next": "Nachher",
                        "hours": "Stunden",
                        "minutes": "Minuten",
                        "seconds": "Sekunden",
                        "unknown": "Unbekannt",
                        "weekdays": [
                            "Sonntag",
                            "Montag",
                            "Dienstag",
                            "Mittwoch",
                            "Donnerstag",
                            "Freitag",
                            "Samstag"
                        ],
                        "months": [
                            "Januar",
                            "Februar",
                            "März",
                            "April",
                            "Mai",
                            "Juni",
                            "Juli",
                            "August",
                            "September",
                            "Oktober",
                            "November",
                            "Dezember"
                        ]
                    },
                    "editor": {
                        "close": "Schließen",
                        "create": {
                            "button": "Neu",
                            "title": "Neuen Eintrag erstellen",
                            "submit": "Erstellen"
                        },
                        "remove": {
                            "confirm": {
                                "_": "Sollen %d Zeilen gelöscht werden?",
                                "1": "Soll diese Zeile gelöscht werden?"
                            },
                            "button": "Entfernen",
                            "title": "Entfernen",
                            "submit": "Entfernen"
                        },
                        "error": {
                            "system": "Ein Systemfehler ist aufgetreten"
                        },
                        "multi": {
                            "title": "Mehrere Werte",
                            "info": "Die ausgewählten Elemente enthalten mehrere Werte für dieses Feld. Um alle Elemente für dieses Feld zu bearbeiten und auf denselben Wert zu setzen, klicken oder tippen Sie hier, andernfalls behalten diese ihre individuellen Werte bei.",
                            "restore": "Änderungen zurücksetzen",
                            "noMulti": "Dieses Feld kann nur einzeln bearbeitet werden, nicht als Teil einer Mengen-Änderung."
                        },
                        "edit": {
                            "button": "Bearbeiten",
                            "title": "Eintrag bearbeiten",
                            "submit": "Bearbeiten"
                        }
                    },
                    "searchPlaceholder": "Suchen...",
                    "stateRestore": {
                        "creationModal": {
                            "button": "Erstellen",
                            "columns": {
                                "search": "Spalten Suche",
                                "visible": "Spalten Sichtbarkeit"
                            },
                            "name": "Name:",
                            "order": "Sortieren",
                            "paging": "Seiten",
                            "scroller": "Scroll Position",
                            "search": "Suche",
                            "searchBuilder": "Such-Baukasten",
                            "select": "Auswahl",
                            "title": "Neue Ansicht erstellen",
                            "toggleLabel": "Inkludiert:"
                        },
                        "duplicateError": "Eine Ansicht mit diesem Namen existiert bereits.",
                        "emptyError": "Name darf nicht leer sein.",
                        "emptyStates": "Keine gespeicherten Ansichten",
                        "removeConfirm": "Bist du dir sicher, dass du %s entfernen möchtest?",
                        "removeError": "Entfernen der Ansicht fehlgeschlagen.",
                        "removeJoiner": " und ",
                        "removeSubmit": "Entfernen",
                        "removeTitle": "Ansicht entfernen",
                        "renameButton": "Umbenennen",
                        "renameLabel": "Neuer Name für %s:",
                        "renameTitle": "Ansicht umbenennen"
                    }
                }
            });
        } );

        // change active nav to intended element
        var element = document.getElementById("element2");
        element.classList.add("active");
        

    <?php echo '</script'; ?>
>
    
</body><?php }
}
