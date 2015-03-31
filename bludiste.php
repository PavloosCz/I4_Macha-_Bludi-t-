<?php
/**
 * Třída která vygeneruje bludište, včetně zdí, startu a cíle. A nade jekradší moznou cestu která se dá projít bludištěm a zvýrazní jí.
 * @author Pavel Machač <machac@playhost.cz>
 * @license FREE
 * @example ukazka.php
 * @package Práce WAP a SI
 */

class bludiste {

    /**
     * Proměná která udává velikost X souřadnice
     * @var int 
     */
    private $x;
    
    /**
     * Proměná která udává velikost Y souřadnice
     * @var int 
     */
    private $y;
    
    /**
     * Zde se ukládají jednotlivá políčka do 2 rozměrného pole. A udržují se v nich informace co se na poli chachází.
     * @var array 
     */
    private $pole = array();
    
    /**
     * Zde se ukládají postupně políčka cesty k cíly.
     * @var arry 
     */
    private $way = array();

    /**
     * Konstruktor třídy vygeneruje Prázné pole o Souřadnicích X a Y
     * @param int $x
     * @param int $y
     */
    function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
        $this->generate_pole();
        $this->generate_bludiste();
        $this->generate_goal();
        $this->generate_start();
        $this->hledej();
        $this->point_goal();
    }

    /**
     * Tato funkce vyhledá nejkradší cestu tak že sospíná od začátku (1) a přičítá vždy 1. 
     */
    function hledej() {
        $m = 1;
        for ($i = 0; $i < 1; $i++) {
            foreach ($this->pole as $keyy => $pole) {
                foreach ($pole as $keyx => $value) {
                    if ($value == $m) {
                        if ($this->pole[$keyy - 1][$keyx] === 0) {
                            $this->pole[$keyy - 1][$keyx] = $m + 1;
                        } if ($this->pole[$keyy + 1][$keyx] === 0) {
                            $this->pole[$keyy + 1][$keyx] = $m + 1;
                        } if ($this->pole[$keyy][$keyx - 1] === 0) {
                            $this->pole[$keyy][$keyx - 1] = $m + 1;
                        } if ($this->pole[$keyy][$keyx + 1] === 0) {
                            $this->pole[$keyy][$keyx + 1] = $m + 1;
                        }
                        $i--;
                    }
                }
            }
            $m++;
        }
    }

    /**
     * Vyznačí nejkradší cestu k cíli
     */
    function point_goal() {
        $end = TRUE;
        $cond = FALSE;
        $inc = 0;
        foreach ($this->pole as $keyy => $pole) {
            foreach ($pole as $keyx => $value) {
                if ($value === "END") {
                    $y = $keyy;
                    $x = $keyx;
                    $this->way[$inc][] = $x;
                    $this->way[$inc][] = $y;
                    for ($i = 0; $i < 1; $i++) {
                        $pole = array();
                        $a = 0;
                        $inc++;
                        if ($this->pole[$y - 1][$x] !== "#" && $this->pole[$y - 1][$x] !== 0 && $this->pole[$y - 1][$x] !== "END") {
                            $pole[$a]["s"] = $this->pole[$y - 1][$x];
                            $pole[$a]["w"] = "t";
                            $cond = TRUE;
                            $a++;
                        } if ($this->pole[$y + 1][$x] !== "#" && $this->pole[$y + 1][$x] !== 0 && $this->pole[$y + 1][$x] !== "END") {
                            $pole[$a]["s"] = $this->pole[$y + 1][$x];
                            $pole[$a]["w"] = "d";
                            $cond = TRUE;
                            $a++;
                        } if ($this->pole[$y][$x - 1] !== "#" && $this->pole[$y][$x - 1] !== 0 && $this->pole[$y][$x - 1] !== "END") {
                            $pole[$a]["s"] = $this->pole[$y][$x - 1];
                            $pole[$a]["w"] = "l";
                            $cond = TRUE;
                            $a++;
                        } if ($this->pole[$y][$x + 1] !== "#" && $this->pole[$y][$x + 1] !== 0 && $this->pole[$y][$x + 1] !== "END") {
                            $pole[$a]["s"] = $this->pole[$y][$x + 1];
                            $pole[$a]["w"] = "r";
                            $cond = TRUE;
                            $a++;
                        }
                        if ($cond) {
                            $min = min($pole);
                            if ($min["w"] == "t") {
                                $y = $y - 1;
                            } elseif ($min["w"] == "d") {
                                $y = $y + 1;
                            } elseif ($min["w"] == "l") {
                                $x = $x - 1;
                            } elseif ($min["w"] == "r") {
                                $x = $x + 1;
                            } if ($min["s"] <= 1) {
                                $i++;
                            } else {
                                $i--;
                            }
                            $this->way[$inc][] = $x;
                            $this->way[$inc][] = $y;
                            $cond = FALSE;
                        }
                    }
                }
            }
        }
    }

    /**
     *  Vygeneruje na mapě náhodně cíl, je pojištěno i to aby se nevygeneroval ve zdi.
     */
    function generate_goal() {
        for ($i = 0; $i < 1; $i++) {
            $x = rand(1, $this->x);
            $y = rand(1, $this->y);
            if ($this->pole[$x][$y] === "#") {
                $i--;
            } else {
                $this->pole[$x][$y] = "END";
            }
        }
    }

    /**
     *  Vygeneruje se náhodně startová pozice od kud má hledat cestu ven z bludiště
     */
    function generate_start() {
        for ($i = 0; $i < 1; $i++) {
            $x = rand(1, $this->x);
            $y = rand(1, $this->y);
            if ($this->pole[$x][$y] === "#") {
                $i--;
            } else {
                $this->pole[$x][$y] = "1";
            }
        }
    }

    /**
     *  Vygeneruje cesty bludiště lagorytmem který bludiště udělá přehlednější
     */
    function generate_bludiste() {
        for ($i = 0; $i < 1; $i++) {
            foreach ($this->pole as $keyy => $pole) {
                foreach ($pole as $keyx => $value) {
                    if ($value === "S") {
                        $maxdelka = 1;
                        $smer = rand(0, 3);
                        if ($smer == 0) {
                            $m = 0;
                            for ($e = 0; $e < 1; $e++) {
                                if ($this->pole[$keyy - $m][$keyx] !== "#") {
                                    $this->pole[$keyy - $m][$keyx] = "#";
                                    $e--;
                                    if ($m == $maxdelka) {
                                        break;
                                    } else {
                                        $m++;
                                    }
                                }
                            }
                        } elseif ($smer == 1) {
                            $m = 0;
                            for ($e = 0; $e < 1; $e++) {
                                if ($this->pole[$keyy + $m][$keyx] !== "#") {
                                    $this->pole[$keyy + $m][$keyx] = "#";
                                    $e--;
                                    if ($m == $maxdelka) {
                                        break;
                                    } else {
                                        $m++;
                                    }
                                }
                            }
                        } elseif ($smer == 2) {
                            $m = 0;
                            for ($e = 0; $e < 1; $e++) {
                                if ($this->pole[$keyy][$keyx - $m] !== "#") {
                                    $this->pole[$keyy][$keyx - $m] = "#";
                                    $e--;
                                    if ($m == $maxdelka) {
                                        break;
                                    } else {
                                        $m++;
                                    }
                                }
                            }
                        } elseif ($smer == 3) {
                            $m = 0;
                            for ($e = 0; $e < 1; $e++) {
                                if ($this->pole[$keyy][$keyx + $m] !== "#") {
                                    $this->pole[$keyy][$keyx + $m] = "#";
                                    $e--;
                                    if ($m == $maxdelka) {
                                        break;
                                    } else {
                                        $m++;
                                    }
                                }
                            }
                        }
                        $i--;
                        break 2;
                    }
                }
            }
        }
    }

    /**
     * Vygeneruje zdy bludiště aby bylo uzavřené celé dokola
     */
    function generate_pole() {
        for ($y = 1; $y <= $this->y; $y++) {
            for ($x = 1; $x <= $this->x; $x++) {
                if ($x == 1) {
                    $this->pole[$x][$y] = "#";
                } elseif ($x == $this->x) {
                    $this->pole[$x][$y] = "#";
                } elseif ($y == 1) {
                    $this->pole[$x][$y] = "#";
                } elseif ($y == $this->y) {
                    $this->pole[$x][$y] = "#";
                } else {
                    $xa = $x - 1;
                    $ya = $y - 1;
                    if ($xa % 2 == 0 AND $ya % 2 == 0) {
                        $this->pole[$x][$y] = "S";
                    } else {
                        $this->pole[$x][$y] = 0;
                    }
                }
            }
        }
    }

    /**
     * Magická funkce tostring sloužící pro výpis bludiště.
     * @return string vrátí vygenerované bludiště.
     */
    function __toString() {
        $return = "<table>";
        for ($y = 1; $y <= count($this->pole); $y++) {
            $return .= "<tr>";
            for ($x = 1; $x <= count($this->pole[$y]); $x++) {
                $return .= "<td class=";
                if ($this->pole[$y][$x] === "#") {
                    $return .= "z";
                } if (in_array(array($x, $y), $this->way)) {
                    $return .= "c";
                }
                $return .=" >";
                $return .= $this->pole[$y][$x];
                $return .= "</td>";
            }
            $return .= "</tr>";
        }
        $return .= "</table>";
        return $return;
    }

}
