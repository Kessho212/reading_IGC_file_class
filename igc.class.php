<?php
class IGC_file{
    private $file;
    private $text;
    private $size;
    private $header;
    private $gpsfix;

    function __construct($file) {
        $this->file = $file;
        $file = implode(';', file($this->file));
        $this->text = explode(";", $file);
        $this->size = count($this->text);
        for($i=1; $i<$this->size; $i++){
            if($this->text[$i][0]!="H"){
                break;
            }else{
                $this->header[] = $this->text[$i];
            }
        }
        for($i=0; $i<$this->size; $i++){
            if($this->text[$i][0]=="B"){
                $this->gpsfix[] = $this->text[$i];
            }
        }
    }
    function header(){
        for($i=0; $i<count($this->header); $i++){
            $record = substr($this->header[$i], 2,3);
            switch ($record) {
                case "DTE":
                    echo "Date: ".date("d M Y",strtotime(substr($this->header[$i], 9,2)."-".substr($this->header[$i], 7,2)."-".substr($this->header[$i], 5,2)))."<br>";
                    break;
                case "FXA":
                    echo "Fix accuracy ".substr($this->header[$i], 5,4)." meters";
                    break;
                case "PLT":
                    echo "Pilot name: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "CM2":
                    echo "Second pilot name: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "GTY":
                    echo "Glider type: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "GID":
                    echo "Glider registration number: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "DTM":
                    echo "GPS datum: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "RFW":
                    echo "Firmware version: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "RHW":
                    echo "Hardware version: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "FTY":
                    echo "Manufacturer and model: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "GPS":
                    echo "Manufacturer, model, channels, maxalt: ".substr($this->header[$i], 5);
                    break;
                case "PRS":
                    echo "Pressure sensor: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "CID":
                    echo "Conpetition ID: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
                case "CCL":
                    echo "Conpetition class: ".explode(':', $this->header[$i])[1]."<br>";
                    break;
            }
        }
    }
    function gpsfix(){
        echo "Latitude, Longitude,  GNSS Alt.<br>";
        for($i=0; $i<count($this->gpsfix); $i++){
            echo "(".substr($this->gpsfix[$i], 7, 2).".".substr($this->gpsfix[$i], 9, 6).", ".substr($this->gpsfix[$i], 15, 3).".".substr($this->gpsfix[$i], 18, 6).", ".substr($this->gpsfix[$i], 30, 5).")"."<br>";
        }
    }
    function firstPoint(){
        echo "First point<br>";
        echo "Latitude, Longitude,  GNSS Alt.<br>";
        echo "(".substr($this->gpsfix[0], 7, 2).".".substr($this->gpsfix[0], 9, 6).", ".substr($this->gpsfix[0], 15, 3).".".substr($this->gpsfix[0], 18, 6).", ".substr($this->gpsfix[0], 30, 5).")"."<br>";
    }
    function lastPoint(){
        echo "Last point<br>";
        echo "Latitude, Longitude,  GNSS Alt.<br>";
        echo "(".substr($this->gpsfix[count($this->gpsfix)-1], 7, 2).".".substr($this->gpsfix[count($this->gpsfix)-1], 9, 6).", ".substr($this->gpsfix[count($this->gpsfix)-1], 15, 3).".".substr($this->gpsfix[count($this->gpsfix)-1], 18, 6).", ".substr($this->gpsfix[count($this->gpsfix)-1], 30, 5).")"."<br>";
    }
}