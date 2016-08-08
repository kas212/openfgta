<?php

    class FGTA_Control
    {
        protected static $labelwidth = 70;

        public $LOCATIONLAYOUT = [0,0,180];

        public function GenerateHtml()
        {
            echo "default";
        }


        public function process_opt($opt)
        {
            if (!array_key_exists('name', $opt))
                die("property 'name' harus didefinisikan pada Control Textbox.");

            $this->name = $opt["name"];
            $this->label = array_key_exists('label', $opt) ? $opt['label'] : '';
            $this->labelwidth = array_key_exists('labelwidth', $opt) ? (int)$opt['labelwidth'] : (int)self::$labelwidth;
            $this->options = array_key_exists('options', $opt) ? $opt['options'] : '';
            $this->location = array_key_exists('location', $opt) ? $opt['location'] : [0,0,180];
            $this->text = array_key_exists('text', $opt) ? $opt['text'] : '';
            $this->directrender = array_key_exists('directrender', $opt) ? $opt['directrender'] : false;

            if (count($this->location) < 3)
                die("property 'location' isinya salah. Format [top, left, width]");

            $this->set_layout(null);
        }

        public function set_layout($LOCATIONLAYOUT) {
            if ($LOCATIONLAYOUT==null) {
                $this->top = (int)$this->location[0];
                $this->left = (int)$this->location[1];
                $this->width = (int)$this->location[2];
            } else {
                $this->top = (int)$LOCATIONLAYOUT[0];
                $this->left = (int)$LOCATIONLAYOUT[1];
                $this->width = (int)$LOCATIONLAYOUT[2];
            }

            $this->inputwidth = $this->width - $this->labelwidth - 10;
        }

    }
