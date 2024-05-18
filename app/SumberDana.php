<?php

namespace App;

// ['Pusat', 'RAS', 'Kepesertaan', 'Pihak Ketiga', 'Wakaf Salman']

enum SumberDana: string
{
    case Pusat = 'Pusat' ;
    case RAS = 'RAS' ;
    case Kepesertaan = 'Kepesertaan' ;
    case PihakKetiga = 'Pihak Ketiga' ;
    case WakafSalman = 'Wakaf Salman' ;
}
