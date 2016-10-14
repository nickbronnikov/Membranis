function styleReader(style) {
    var css=JSON.parse(style);
    fontFamily(css.fontfamily);
    $('#reader').css('font-size',css.fontsize);
    $('#reader').css('color',css.color);
    $('#reader').css('background-color',css.backgroundcolor);
    $('#reader').css('text-align',css.textalign);
}
function fontFamily(font) {
    var fonts='Roboto Open Sans PT Sans Ubuntu PT Serif';
    if (fonts.indexOf(font)==-1) {
        $('#reader').css('font-family', "'" + font + "'");
    } else {
        switch (font){
            case 'Roboto':
                $('head').append('<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700&subset=cyrillic-ext,latin-ext" rel="stylesheet">');
                $('#reader').css('font-family', "'" + font + "'");
                break;
            case 'Open Sans':
                $('head').append('<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&subset=cyrillic-ext,latin-ext" rel="stylesheet">');
                $('#reader').css('font-family', "'" + font + "'");
                break;
            case 'PT Sans':
                $('head').append('<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700&subset=cyrillic-ext,latin-ext" rel="stylesheet">');
                $('#reader').css('font-family', "'" + font + "'");
                break;
            case 'Ubuntu':
                $('head').append('<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,400i,700&subset=cyrillic-ext,latin-ext" rel="stylesheet">');
                $('#reader').css('font-family', "'" + font + "'");
                break;
            case 'PT Serif':
                $('head').append('<link href="https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700&subset=cyrillic-ext,latin-ext" rel="stylesheet">');
                $('#reader').css('font-family', "'" + font + "'");
                break;
        }
    }
}