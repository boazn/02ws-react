var n0 = parseInt( "0" );
var f0 = parseFloat( "0.0" );
var AG = f0;   // Moon's age
var DI = f0;   // Moon's distance in earth radii
var LA = f0;   // Moon's ecliptic latitude
var LO = f0;   // Moon's ecliptic longitude
var Phase = " ";
var Zodiac = " ";

function initialize()
{
    var d = new Date();

    document.calc.year.value  = d.getFullYear();
    document.calc.month.value = d.getMonth() + 1;
    document.calc.day.value   = d.getDate();
}

function calculate()
{
    var year  = parseInt( document.calc.year.value, 10 );    
    var month = parseInt( document.calc.month.value, 10 );    
    var day   = parseInt( document.calc.day.value, 10 );

    if( !isdayofmonth( year, month, day ) )
    {
        alert( "Invalid date" );
        return;
    }

    moon_posit( year, month, day );

    document.calc.age.value = round2( AG );
    document.calc.dst.value = round2( DI );
    document.calc.faz.value = Phase;
    document.calc.lat.value = round2( LA );
    document.calc.lon.value = round2( LO );
    document.calc.sgn.value = Zodiac;
}

var n28 = parseInt( "28" );
var n30 = parseInt( "30" );
var n31 = parseInt( "31" );
var dim = new Array( n31, n28, n31, n30, n31, n30, n31, n31, n30, n31, n30, n31 );

function isdayofmonth( y, m, d )
{
    if( m != 2 )
    {
        if( 1 <= d && d <= dim[m-1] )
            return true;
        else
            return false;
    }

    var feb = dim[1];
 
    if( isleapyear( y ) )
        feb += 1;                                   // is leap year

    if( 1 <= d && d <= feb )
        return true;

    return false;       
}

function isleapyear( y )
{
    var x = Math.floor( y - 4*Math.floor( y/4 ) );
    var w = Math.floor( y - 100*Math.floor( y/100 ) );
    var z = Math.floor( y - 400*Math.floor( y/400 ) );

    if( x == 0 )                           // possible leap year
    {
        if( w == 0 && z != 0 )
            return false;                  // not leap year
        else
            return true;                   // is leap year
    }

    return false;
}

function backup( n )
{
    var year = parseInt( document.calc.year.value, 10 );
    var month = parseInt( document.calc.month.value, 10 );
    var day = parseInt( document.calc.day.value, 10 );

    switch( n )
    {
    case 1:
        document.calc.year.value = year - 1;
        calculate();
        break;
    case 2:
        if( month < 2 )
        {
            document.calc.month.value = 12;
            document.calc.year.value = year - 1;
        }
        else
            document.calc.month.value = month - 1;
        calculate();
        break;
    case 3:
        if( day < 2 )
        {
            if( month < 2 )
            {
                document.calc.month.value = 12;
                document.calc.year.value = year - 1;
            }
            else
                document.calc.month.value = month - 1;
            
            month = parseInt( document.calc.month.value, 10 );
            if( month == 2 && isleapyear( year ) )
                document.calc.day.value = 29;
            else 
                document.calc.day.value = dim[month-1];
        }
        else
            document.calc.day.value = day - 1;
        calculate();
        break;
    }
}

function advance( n )
{
    var year = parseInt( document.calc.year.value, 10 );
    var month = parseInt( document.calc.month.value, 10 );
    var day = parseInt( document.calc.day.value, 10 );

    switch( n )
    {
    case 1:
        document.calc.year.value = year + 1;
        calculate();
        break;
    case 2:
        if( month < 12 )
            document.calc.month.value = month + 1;
        else
        {
            document.calc.month.value = 1;
            document.calc.year.value = year + 1;
        }
        calculate();
        break;
    case 3:
        if( isdayofmonth( year, month, day + 1 ) )
            document.calc.day.value = day + 1;
        else
        {
            if( month < 12 )
                document.calc.month.value = month + 1;
            else
            {
                document.calc.month.value = 1;
                document.calc.year.value = year + 1;
            }

            document.calc.day.value = 1;
        }
        calculate();
        break;
    }
}

// compute moon position and phase
function moon_posit( Y, M, D )
{
    var YY = n0;
    var MM = n0;
    var K1 = n0; 
    var K2 = n0; 
    var K3 = n0;
    var JD = n0;
    var IP = f0;
    var DP = f0;
    var NP = f0;
    var RP = f0;
    
    // calculate the Julian date at 12h UT
    YY = Y - Math.floor( ( 12 - M ) / 10 );       
    MM = M + 9; 
    if( MM >= 12 ) MM = MM - 12;
    
    K1 = Math.floor( 365.25 * ( YY + 4712 ) );
    K2 = Math.floor( 30.6 * MM + 0.5 );
    K3 = Math.floor( Math.floor( ( YY / 100 ) + 49 ) * 0.75 ) - 38;
    
    JD = K1 + K2 + D + 59;                  // for dates in Julian calendar
    if( JD > 2299160 ) JD = JD - K3;        // for Gregorian calendar
        
    // calculate moon's age in days
    IP = normalize( ( JD - 2451550.1 ) / 29.530588853 );
    AG = IP*29.53;
    
    if(      AG <  1.84566 ) Phase = "NEW";
    else if( AG <  5.53699 ) Phase = "Evening crescent";
    else if( AG <  9.22831 ) Phase = "First quarter";
    else if( AG < 12.91963 ) Phase = "Waxing gibbous";
    else if( AG < 16.61096 ) Phase = "FULL";
    else if( AG < 20.30228 ) Phase = "Waning gibbous";
    else if( AG < 23.99361 ) Phase = "Last quarter";
    else if( AG < 27.68493 ) Phase = "Morning crescent";
    else                     Phase = "NEW";

    IP = IP*2*Math.PI;                      // Convert phase to radians

    // calculate moon's distance
    DP = 2*Math.PI*normalize( ( JD - 2451562.2 ) / 27.55454988 );
    DI = 60.4 - 3.3*Math.cos( DP ) - 0.6*Math.cos( 2*IP - DP ) - 0.5*Math.cos( 2*IP );

    // calculate moon's ecliptic latitude
    NP = 2*Math.PI*normalize( ( JD - 2451565.2 ) / 27.212220817 );
    LA = 5.1*Math.sin( NP );

    // calculate moon's ecliptic longitude
    RP = normalize( ( JD - 2451555.8 ) / 27.321582241 );
    LO = 360*RP + 6.3*Math.sin( DP ) + 1.3*Math.sin( 2*IP - DP ) + 0.7*Math.sin( 2*IP );

    if(      LO <  33.18 ) Zodiac = "Pisces";
    else if( LO <  51.16 ) Zodiac = "Aries";
    else if( LO <  93.44 ) Zodiac = "Taurus";
    else if( LO < 119.48 ) Zodiac = "Gemini";
    else if( LO < 135.30 ) Zodiac = "Cancer";
    else if( LO < 173.34 ) Zodiac = "Leo";
    else if( LO < 224.17 ) Zodiac = "Virgo";
    else if( LO < 242.57 ) Zodiac = "Libra";
    else if( LO < 271.26 ) Zodiac = "Scorpio";
    else if( LO < 302.49 ) Zodiac = "Sagittarius";
    else if( LO < 311.72 ) Zodiac = "Capricorn";
    else if( LO < 348.58 ) Zodiac = "Aquarius";
    else                   Zodiac = "Pisces";

    // so longitude is not greater than 360!
    if ( LO > 360 ) LO = LO - 360;
}

// round to 2 decimal places    
function round2( x )
{
    return ( Math.round( 100*x )/100.0 );
}
    
// normalize values to range 0...1    
function normalize( v )
{
    v = v - Math.floor( v  ); 
    if( v < 0 )
        v = v + 1;
        
    return v;
}

// clear input
function allclear()
{
    document.calc.year.value='0';
    document.calc.month.value='0';
    document.calc.day.value='0';
}