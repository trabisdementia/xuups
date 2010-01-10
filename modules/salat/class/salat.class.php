<?php
// Source: http://qasweb.org/qasforum/index.php?showtopic=177&st=0
// By: Mohamad Magdy <mohamad_magdy_egy@hotmail.com>

class Salat {
    var $year = 1975; // السنة
    var $month = 8; // الشهر
    var $day = 2; // اليوم
    var $zone = 2; // فرق التوقيت العالمى
    var $long = 29.371; // خط الطول الجغرافى للمكان
    var $lat = 47.988; // خط العرض الجغرافى
    var $AB2 =  - 0.833333; // زاوية الشروق والغروب
    var $AG2 =  - 18; // زاوية العشاء
    var $AJ2 =  - 18; // زاوية الفجر
    var $school = 'Shafi'; // المذهب

    function setDate($d = 2, $m = 8, $y = 1975) {
        $this->year = $y;
        $this->month = $m;
        $this->day = $d;
    }

    function setLocation($l1 = 29.371, $l2 = 47.988, $z = 2) {
        $this->long = $l1;
        $this->lat = $l2;
        $this->zone = $z;
    }

    function setConf($sch = 'Shafi', $sunriseArc =  - 0.833333, $ishaArc =  -
        18, $fajrArc =  - 18) {
        $this->school = $sch;
        $this->AB2 = $sunriseArc;
        $this->AG2 = $ishaArc;
        $this->AJ2 = $fajrArc;
    }

    function getPrayTime() {
        $prayTime = array();

        // نحسب اليوم الجوليانى
        $d = ((367 * $this->year) - (floor((7 / 4) * ($this->year + floor(
            ($this->month + 9) / 12)))) + floor(275 * ($this->month / 9)) +
            $this->day - 730531.5);

        // نحسب طول الشمس الوسطى
        $L = ((280.461 + 0.9856474 * $d) % 360) + ((280.461 + 0.9856474 * $d) -
            (int)(280.461 + 0.9856474 * $d));

        // ثم نحسب حصة الشمس الوسطى
        $M = ((357.528 + 0.9856003 * $d) % 360) + ((357.528 + 0.9856003 * $d) -
            (int)(357.528 + 0.9856003 * $d));

        // ثم نحسب طول الشمس البروجى
        $lambda = $L + 1.915 * sin($M * pi() / 180) + 0.02 * sin(2 * $M * pi()
            / 180);

        // ثم نحسب ميل دائرة البروج
        $obl = 23.439 - 0.0000004 * $d;

        // ثم نحسب المطلع المستقيم
        $alpha = atan(cos($obl * pi() / 180) * tan($lambda * pi() / 180)) * 180
            / pi();
        $alpha = $alpha - (360 * floor($alpha / 360));

        // ثم نعدل المطلع المستقيم
        $alpha = $alpha + 90 * ((int)($lambda / 90) - (int)($alpha / 90));

        // نحسب الزمن النجمى بالدرجات الزاوية
        $ST = ((100.46 + 0.985647352 * $d) % 360) + ((100.46 + 0.985647352 * $d)
            - (int)(100.46 + 0.985647352 * $d));

        // ثم نحسب ميل الشمس الزاوى
        $Dec = asin(sin($obl * pi() / 180) * sin($lambda * pi() / 180)) * 180 /
            pi();

        // نحسب زوال الشمس الوسطى
        if ($alpha > $ST) {
            $noon = (($alpha - $ST) % 360) + (($alpha - $ST) - (int)($alpha -
                $ST));
        } else {
            $noon = (($ST - $alpha) % 360) - (($ST - $alpha) - (int)($ST -
                $alpha));
        }

        // ثم الزوالى العالمى
        $un_noon = $noon - $this->long;

        // ثم الزوال المحلى
        $local_noon = $un_noon / 15+$this->zone;

        // وقت صلاة الظهر
        $Dhuhr = $local_noon / 24;
        $Dhuhr_h = (int)($Dhuhr * 24 * 60 / 60);
        $Dhuhr_m = sprintf("%02d", ($Dhuhr * 24 * 60) % 60);
        $prayTime[2] = "$Dhuhr_h:$Dhuhr_m";

        if ($this->school == 'Shafi') {
            // نحسب إرتفاع الشمس لوقت صلاة العصر حسب المذهب الشافعي
            $U = atan(2+tan(($this->lat - $Dec) * pi() / 180)) * 180 / pi();

            // ثم نحسب قوس الدائر أى الوقت المتبقى من وقت الظهر حتى صلاة العصر حسب المذهب الشافعي
            $W = acos((sin((90-$U) * pi() / 180) - sin($Dec * pi() / 180) * sin
                ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos
                ($this->lat * pi() / 180))) * 180 / pi() / 15;

            // وقت صلاة العصر حسب المذهب الشافعي
            $Z = $local_noon + $W;
            $SAsr = $Z / 24;
            $SAsr_h = (int)($SAsr * 24 * 60 / 60);
            $SAsr_m = sprintf("%02d", ($SAsr * 24 * 60) % 60);
            $prayTime[3] = "$SAsr_h:$SAsr_m";
        } else {
            // نحسب إرتفاع الشمس لوقت صلاة العصر حسب المذهب الحنفي
            $T = atan(1+tan(($this->lat - $Dec) * pi() / 180)) * 180 / pi();

            // ثم نحسب قوس الدائر أى الوقت المتبقى من وقت الظهر حتى صلاة العصر حسب المذهب الحنفي
            $V = acos((sin((90-$T) * pi() / 180) - sin($Dec * pi() / 180) * sin
                ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos
                ($this->lat * pi() / 180))) * 180 / pi() / 15;

            // وقت صلاة العصر حسب المذهب الحنفي
            $X = $local_noon + $V;
            $HAsr = $Dhuhr + $V / 24;
            $HAsr_h = (int)($HAsr * 24 * 60 / 60);
            $HAsr_m = sprintf("%02d", ($HAsr * 24 * 60) % 60);
            $prayTime[3] = "$HAsr_h:$HAsr_m";
        }

        // نحسب نصف قوس النهار
        $AB = acos((SIN($this->AB2 * pi() / 180) - sin($Dec * pi() / 180) * sin
            ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos($this
            ->lat * pi() / 180))) * 180 / pi();

        // وقت الشروق
        $AC = $local_noon - $AB / 15;
        $Sunrise = $AC / 24;
        $Sunrise_h = (int)($Sunrise * 24 * 60 / 60);
        $Sunrise_m = sprintf("%02d", ($Sunrise * 24 * 60) % 60);
        $prayTime[1] = "$Sunrise_h:$Sunrise_m";

        // وقت الغروب
        $AE = $local_noon + $AB / 15;
        $Sunset = $AE / 24;
        $Sunset_h = (int)($Sunset * 24 * 60 / 60);
        $Sunset_m = sprintf("%02d", ($Sunset * 24 * 60) % 60);
        $prayTime[4] = "$Sunset_h:$Sunset_m";

        // نحسب فضل الدائر وهو الوقت المتبقى من وقت صلاة الظهر إلى وقت العشاء
        $AG = acos((sin($this->AG2 * pi() / 180) - sin($Dec * pi() / 180) * sin
            ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos($this
            ->lat * pi() / 180))) * 180 / pi();

        // وقت صلاة العشاء
        $AH = $local_noon + ($AG / 15);
        $Isha = $AH / 24;
        $Isha_h = (int)($Isha * 24 * 60 / 60);
        $Isha_m = sprintf("%02d", ($Isha * 24 * 60) % 60);
        $prayTime[5] = "$Isha_h:$Isha_m";

        // نحسب فضل دائر الفجر وهو الوقت المتبقى من وقت صلاة الفجر حتى وقت صلاة الظهر
        $AJ = acos((sin($this->AJ2 * pi() / 180) - sin($Dec * pi() / 180) * sin
            ($this->lat * pi() / 180)) / (cos($Dec * pi() / 180) * cos($this
            ->lat * pi() / 180))) * 180 / pi();

        // وقت صلاة الفجر
        $AK = $local_noon - $AJ / 15;
        $Fajr = $AK / 24;
        $Fajr_h = (int)($Fajr * 24 * 60 / 60);
        $Fajr_m = sprintf("%02d", ($Fajr * 24 * 60) % 60);
        $prayTime[0] = "$Fajr_h:$Fajr_m";

        return $prayTime;
    }
}

?>
