$( document ).ready( function() {
    // Enable tooltips
    $( '[data-toggle="tooltip"]').tooltip();

    //Add new student
    $( '#addStudentForm' ).submit( function() {
        var name = $( this).find( '[name="name"]').val();
        var surname = $( this).find( '[name="surname"]').val();
        var pesel = $( this).find( '[name="pesel"]').val();
        var street_address = $( this).find( '[name="street_address"]').val();

        if( name.length <= 0 || name.length > 15 ) {
            alert( 'Imię za krótkie bądź za długie!' )
        } else if( surname.length <= 0 || name.length > 25 ) {
            alert( 'Nazwisko za krótkie bądź za długie!' )
        } else if( pesel.length != 11 || pesel <= 0 ) {
            alert( 'Niepoprawny pesel!' )
        } else if( street_address.length <= 0 || street_address.length > 255 ) {
            alert( 'Podaj poprawny adres!' )
        } else {
            //Process form using post ajax
            $.ajax({
                url: 'students/add',
                type: 'post',
                data: $( '#addStudentForm').serialize(),
                error: function() {
                    alert( 'Napotkano problem przy wysłaniu żądania o dodanie ucznia!' );
                },
                success: function( data ) {
                    var error = $( data).find( 'error' );

                    if( error.length > 0 ) {
                        alert( error.text() );
                    } else {
                        var student = $( data ).find( "student" );

                        var id = $( student ).find( 'id' ).text();
                        var rowId = 'student_' + id;

                        $( '#students').append( '<tr style="display: none;" id="' + rowId + '"></tr>' );

                        var row = $( '#' + rowId );

                        $.each( student.find( '*' ), function( index, data ) {
                            // We ignore id
                            if( data.nodeName != 'id' ) {
                                $( row ).append( '<td id="' + data.nodeName + '" data-fillable="true"></td>' );
                                $( row ).find( '#' + data.nodeName ).text( $( data ).text() );
                            }
                        } );

                        //Add actions
                        $( row ).append( '<td><div id="beforeEdit">' +
                            '<button id="buttonEdit" onClick="editStudent( ' + rowId + ' )" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edytuj ucznia">' +
                                '<span class="glyphicon glyphicon-cog"></span>' +
                            '</button>' +

                            ' <button onClick="removeStudent( ' + id + ', \'' + $( '[name="_token"]' ).val() + '\' )" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Usuń ucznia">' +
                                '<span class="glyphicon glyphicon-remove"></span>' +
                            '</button>' +
                        '</div>' +
                        "                        <div id=\"onEdit\">" +
                        "<button onClick=\"saveStudent( student_" + id + ", " + id + " )\" type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Zapisz\">" +
                            "<span class=\"glyphicon glyphicon-ok\"></span>" +
                            "</button> "+

                            "<button onClick=\"cancelStudent( student_" + id + " )\" type=\"button\" class=\"btn btn-warning btn-sm\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Anuluj\">" +
                                "<span class=\"glyphicon glyphicon-remove\"></span>" +
                            "</button>" +
                        "</div></td>");


                        $( row ).show( 'slow' );
                        $( 'html, body' ).animate( { scrollTop: $( row ).offset().top }, 'slow' );

                        // Reset form inputs
                        $( '#addStudentForm')[0].reset();

                        // Update counter
                        $( '#studentsCount').html( $( 'tr' ).length ) - 1;
                    }
                }
            });
        }

        return false;
    } );
} );


function removeStudent( studentId, token ) {
    var id = parseInt( studentId );

    var accept = confirm( 'Na pewn chcesz usunąć ucznia?' );

    if( !accept ) {
        return;
    }

    if( id <= 0 ) {
        return;
    }

    $.ajax({
        url: 'students/remove/' + id + '/' + token,
        type: 'get',
        cache: false,
        dataType: 'xml',
        error: function() {
            alert( 'Napotkano jakieś problemy z wysłaniem żądania!' );
        },
        success: function( data ) {
            var error = $( data).find( 'error' );

            if( error.length > 0 ) {
                alert( error.text() );
            } else {
                var response = $( data ).find( 'response' );

                if( response.length > 0 ) {
                    $( '#student_' + id).hide( 'slow', function() {
                        this.remove();
                        // Update counter
                        $( '#studentsCount').html( parseInt( $( '#studentsCount').text() ) - 1 );
                    });
                } else {
                    alert( 'Serwer nie zwrócił poprawnej odpowiedzi, nie można usunąć wpisu!' )
                }
            }
        }
    });
}

function editStudent( row ) {
    var fillables = $( row ).find( '[data-fillable="true"]' );
    var dataCopy = {};

    // Hide 'edit' and 'remove' button
    $( row ).find( '#beforeEdit').css( 'display', 'none' );

    //Show 'save' and 'cancel' button
    $( row ).find( '#onEdit').css( 'display', 'block' );

    $.each( fillables, function( index, node ) {
        var value = $( node ).html();
        var field = $( node ).attr( 'id' );

        dataCopy[ field ] = value;

        $( node ).html( '<input type="text" id="input_' + field + '" value="' + value + '">' );
    });
}

function saveStudent( row, id ) {
    var data = '';

    $.each( $( row ).find( 'input' ), function( index, node ) {
        data += $( node ).attr( 'id').split( '_' )[1] + '=' + encodeURIComponent( $( node ).val() ) + '&';
    });

    $.ajax({
        url: 'students/edit/' + id + '/' + $( '[name="_token"]').val(),
        type: 'post',
        data: data,
        error: function() {
            alert( 'Napotkano problem przy wysłaniu żądania o edycję ucznia!' );
        },
        success: function( data ) {
            var error = $( data ).find( 'error' );

            if( error.length > 0 ) {
                alert( error.text() );
            } else {
                // Show 'edit' and 'remove' button
                $( row ).find( '#beforeEdit').css( 'display', 'block' );

                // Hide 'save' and 'cancel' button
                $( row ).find( '#onEdit').css( 'display', 'none' );

                var student = $( data ).find( 'student' );

                var id = $( student ).find( 'id' ).text();
                var rowId = 'student_' + id;

                $.each( student.find( '*' ), function( index, node ) {
                    // We ignore id
                    if( data.nodeName != 'id' ) {
                        $( row ).find( '#' + node.nodeName ).text( $( node ).text() );
                    }
                } );
            }
        }
    });


}

function cancelStudent( row ) {
    // Show 'edit' and 'remove' button
    $( row ).find( '#beforeEdit').css( 'display', 'block' );

    // Hide 'save' and 'cancel' button
    $( row ).find( '#onEdit').css( 'display', 'none' );

    $.each( $( row ).find( 'input' ), function( index, node ) {
        $( node).replaceWith( $( node ).attr( 'value' ) );
    });
}

function showDays( id ) {

    $( '#' + id ).toggle( 'slow' );
}

function setPresent( hour, studentId, date, present ) {
    if( hour < 0 || hour >= 8 ) {
        alert( 'Nie możesz definiować obecności na godzinie ósmiej i późniejszych!' );
        return;
    }

    //Process form using post ajax
    $.ajax({
        url: 'set',
        type: 'post',
        data: 'present=' + parseInt( present ) + '&student_id=' + studentId + '&date=' + encodeURIComponent( date ) + '&hour=' + hour + '&_token=' + $( '[name="_token"]').val(),
        error: function() {
            alert( 'Napotkano problem przy wysłaniu żądania o ustawienie obecności!' );
        },
        success: function( data ) {
            var error = $( data ).find( 'error' );

            if( error.length > 0 ) {
                alert( error.text() );
            } else {
                if( present ) {
                    $( '#student_' + studentId ).find( '#hour_' + hour ).first().html( '<span class="glyphicon glyphicon-ok"></span>' );
                } else {
                    $( '#student_' + studentId ).find( '#hour_' + hour ).first().html( '<span class="glyphicon glyphicon-remove"></span>' );
                }
            }
        }
    });

    return false;
}