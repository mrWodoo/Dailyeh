$( document ).ready( function() {
    // Enable tooltips
    $( '[data-toggle="tooltip"]').tooltip();

    //Add new student
    $( '#addStudentForm').submit( function() {
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
                    alert( data );
                }
            });
        }

        return false;
    } );
} );


function removeStudent( studentId ) {
    var id = parseInt( studentId );


    if( id <= 0 ) {
        return;
    }

    $.ajax({
        url: 'students/remove/' + id,
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
                var response = $( data).find( 'response' );

                if( response.length > 0 ) {
                    $( '#student_' + id).hide( 'slow', function() {  this.remove(); } );
                } else {
                    alert( 'Serwer nie zwrócił poprawnej odpowiedzi, nie można usunąć wpisu!' )
                }
            }
        }
    });
}