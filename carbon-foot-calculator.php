<?php
   /**
    * Plugin Name: Calculador de Impacto Ambiental 1.0
    * Description: Este plugin calcula el impacto ambiental
    * Version: 1.0.0
    * Author: Manuel Jesús Aguair Gámez
    * License: GPL2
    */


   if(!defined('ABSPATH')) die();

   define("TEST_DIR", __FILE__);
   define("TEST_PLUGIN_DIR", plugin_dir_path(TEST_DIR));
   define("TEST_PLUGIN_URL", plugin_dir_url(TEST_DIR));

   require_once TEST_PLUGIN_DIR."includes/classes/main.php";
   require_once TEST_PLUGIN_DIR."includes/classes/main.php";
   $main = new main;

   register_activation_hook( TEST_DIR, [$main, 'activate'] );
   register_deactivation_hook( TEST_DIR, [$main, 'deactivate'] );

   //Add plugin css
   function myPluginCss(){
      //Bootstrap
      wp_register_style('bootstrapcss', TEST_PLUGIN_URL."public/css/bootstrap.min.css");
      wp_enqueue_style('bootstrapcss');

      wp_register_style('font-awesomecss', TEST_PLUGIN_URL."public/css/font-awesome.css");
      wp_enqueue_style('font-awesomecss');

      //Plugin
      wp_register_style('wizardcss', TEST_PLUGIN_URL."public/css/wizard.css");
      wp_enqueue_style('wizardcss');

      wp_register_style('rounded-radio', TEST_PLUGIN_URL."public/css/rounded-radio.css");
      wp_enqueue_style('rounded-radio');

      wp_register_style('circular-meter', TEST_PLUGIN_URL."public/css/circular-meter.css");
      wp_enqueue_style('circular-meter');
   }

   // Add plugin scripts
   function myPluginScripts(){
      //Bootstrap
      wp_register_script( 'bootstrapjs', TEST_PLUGIN_URL."public/js/bootstrap.bundle.min.js");
      wp_enqueue_script('bootstrapjs');

      //Jquery
      wp_register_script( 'jqueryjs', TEST_PLUGIN_URL. "public/js/jquery.min.js");
      wp_enqueue_script('jqueryjs');

      //Plugin
      wp_register_script( 'wizardjs', TEST_PLUGIN_URL."public/js/wizard.js");
      wp_enqueue_script('wizardjs');

      wp_register_script( 'raphaeljs', TEST_PLUGIN_URL."public/js/raphael.min.js");
      wp_enqueue_script('raphaeljs');    

      wp_register_script( 'justgagejs', TEST_PLUGIN_URL."public/js/justgage.js");
      wp_enqueue_script('justgagejs'); 
      
   }

   add_action('wp_enqueue_scripts', 'myPluginCss', 999);
   add_action('wp_enqueue_scripts', 'myPluginScripts', 999);

   add_shortcode('carbon-foot', 'myForm');

   function questionsMenu($language="COL"){

     $menu = [
        "Vivienda",
        "Servicios",
        "Transporte",
        "Vuelos",
        "Alimentación",
        "Resultados"
     ]; 
    if($language=="USA"){
        $menu = [
            "Living place",
            "Services",
            "Transportation",
            "Flights",
            "Food",
            "Results"
         ];        
    }

    ?> 

    <ul id="progressbar">
        <li class="active" id="house"><strong><?php echo $menu[0]; ?></strong></li>
        <li id="receipt"><strong><?php echo $menu[1]; ?></strong></li>
        <li id="car"><strong><?php echo $menu[2]; ?></strong></li>
        <li id="plane"><strong><?php echo $menu[3]; ?></strong></li>
        <li id="meat"><strong><?php echo $menu[4]; ?></strong></li>
        <li id="confirm"><strong><?php echo $menu[5]; ?></strong></li>
    </ul>

    <?php
   }

   function questionOne($language="COL"){

        $question= [
            "COL" => "1. ¿Cuantas personas más viven en tu casa?",
            "MEX" => "1. ¿Cuantas personas más viven en tu casa?",
            "USA" => "1. How many other people live in your household?"            
        ];

        ?>
            <div class="row">
                <div class="col-6">
                    <img src="<?php echo TEST_PLUGIN_URL.'public/images/1.png'; ?>" width="80%">
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fs-title"><?php echo $question[$language]; ?></h2>
                        </div>
                    </div>
                    <div class="price-box">

                    <div id="slider"></div>

                    </div>
                    <div class="options">                
                        <?php
                            for($i=1; $i<8; $i++){
                                ?>
                                <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">
                                    <input type="radio" class="hidden peer" name="questionOne"  data-type="int" value="<?php echo $i; ?>" data-v-05d2fc82="">
                                    <div class="flex items-center justify-between cursor-pointer square"  data-v-05d2fc82=""><?php echo $i; ?></div>
                                </label>
                                <?php
                            }
                        ?>
                    </div>                    
                </div>
            </div>
        <?php
   }

   function questionTwo($language="COL"){

    $money = [
        "COL" => "$ COP",
        "MEX" => "$ MXN",
        "USA" => "$ USD"
    ];

    $question= [
        "COL" => "2. Indica tu costo de cada tipo de servicio público (".$money[$language].")",
        "MEX" => "2. Indica tu costo de cada tipo de servicio público (".$money[$language].")",
        "USA" => "2. Enter your cost of each type of public service: "            
    ];

    $questionOne = [
        "COL" => "Electricidad",
        "MEX" => "Electricidad",
        "USA" => "Electricity" 
    ];

    $questionTwo = [
        "COL" => "Gas",
        "MEX" => "Gas",
        "USA" => "Gas" 
    ];

    ?>
        <div class="row">
            <div class="col-6">
                <img src="<?php echo TEST_PLUGIN_URL.'public/images/2.png'; ?>" width="80%">
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fs-title"><?php echo $question[$language]; ?></h2>
                    </div>
                </div>

                <label class="fieldlabels"><?php echo $questionOne[$language]; ?>: </label> <output id="outputElect">0</output> <?php echo $money[$language] ?>  <br>
               
                <input name="questionTwoElectricity" type="range" value="0" min="0" max="1000" oninput="document.getElementById('outputElect').value = this.value">
                    
                <label class="fieldlabels"><?php echo $questionTwo[$language]; ?>: </label> <output id="outputGas">0</output> <?php echo $money[$language] ?>   <br>
               
                <input name="questionTwoGas" type="range" value="0" min="0" max="1000" oninput="document.getElementById('outputGas').value = this.value"> 

                
            </div>
        </div>
    <?php
    }

    function questionThree($language="COL"){

        $money = [
            "COL" => "$ COP",
            "MEX" => "$ MXN",
            "USA" => "$ USD"
        ];
    
        $question= [
            "COL" => "Selecciona el medio de transporte que usas, millas recorridas y factura mensual:",
            "MEX" => "Selecciona el medio de transporte que usas, millas recorridas y factura mensual:",
            "USA" => "Select the means of transport you use, miles traveled and monthly bill:"            
        ];

        $questionOne = [
            "COL" => "Factura mensual de combustible",
            "MEX" => "Factura mensual de combustible",
            "USA" => "Monthly fuel bill" 
        ];
    
        $questionTwo = [
            "COL" => "Millas mensuales recorridas",
            "MEX" => "Millas mensuales recorridas",
            "USA" => "Monthly miles traveled" 
        ];

        $transportations =[
            "COL" => [
                'car' => 'Auto',
                'cab' => 'Taxi',
                'motorcycle' => 'Motocicleta',
                'bike' => 'Bicileta',
                'scooter' => 'Scooter',
                'Transporte publico' => 'Transporte publico',
            ],
            "MEX" => [
                'car' => 'Auto',
                'cab' => 'Taxi',
                'motorcycle' => 'Motocicleta',
                'bike' => 'Bicileta',
                'scooter' => 'Scooter',
                'publicTransport' => 'Transporte publico',
            ],
            "USA" => [
                'car' => 'Car',
                'cab' => 'Cab',
                'motorcycle' => 'Motorcycle',
                'bike' => 'Bike',
                'scooter' => 'Scooter',
                'publicTransport' => 'Public transport',
            ]
        ];
    
        ?>
            <div class="row">
                <div class="col-6">
                    <img src="<?php echo TEST_PLUGIN_URL.'public/images/3.png'; ?>" width="80%">
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fs-title">2. <?php echo $question[$language]; ?></h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="funkyradio">
                                <?php                                    
                                    foreach($transportations[$language] as $key => $transport){
                                        ?>
                                            <div class="funkyradio-primary">
                                                <input type="checkbox" name="chkTransportation" id="chk<?php echo $key; ?>" />
                                                <label for="chk<?php echo $key; ?>"><?php echo $transport; ?></label>
                                            </div>
                                        <?php
                                    }
                                ?>
                            </div>                        
                        </div>
    
                        <div class="col-8">
                            <label class="fieldlabels"><?php echo $questionOne[$language]; ?>: </label> <output id="ThreeGas">0</output> <?php echo $money[$language] ?>  <br>
                        
                            <input name="questionThreeGas" type="range" value="0" min="0" max="1000" oninput="document.getElementById('ThreeGas').value = this.value">
                                
                            <label class="fieldlabels"><?php echo $questionTwo[$language]; ?>: </label> <output id="outputMiles">0</output> <?php echo $money[$language] ?>   <br>
                        
                            <input name="questionThreeMiles" type="range" value="0" min="0" max="1000" oninput="document.getElementById('outputMiles').value = this.value"> 
                        </div>
                    </div>
                    
                </div>
            </div>
        <?php
    }

    function questionFour($language="COL"){
      
        $money = [
            "COL" => "Vuelos",
            "MEX" => "Vuelos",
            "USA" => "Flights "
        ];

        $question= [
            "COL" => "4. Cantidad de vuelos que realizas al año",
            "MEX" => "4. Cantidad de vuelos que realizas al año",
            "USA" => "4. Number of flights you make yearly"            
        ];

        ?>
            <div class="row">
                <div class="col-6">
                    <img src="<?php echo TEST_PLUGIN_URL.'public/images/4.png'; ?>" width="80%">
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fs-title"><?php echo $question[$language]; ?></h2>
                        </div>
                    </div>

                    <label class="fieldlabels"><?php echo $money[$language]; ?>: </label> <output id="outputFlights">0</output> <?php echo $money[$language]; ?>  <br>
                
                    <input name="questionFourFlights" type="range" value="0" min="0" max="500" oninput="document.getElementById('outputFlights').value = this.value">
                    
                </div>
            </div>
        <?php
   }

   function questionFive($language="COL"){

    $question= [
        "COL" => "5. ¿Cuantas veces a la semana consumes carne roja?",
        "MEX" => "5. ¿Cuantas veces a la semana consumes carne roja?",
        "USA" => "5. How many times a week do you eat red meat?"            
    ];

    ?>
        <div class="row">
            <div class="col-6">
                <img src="<?php echo TEST_PLUGIN_URL.'public/images/5.png'; ?>" width="80%">
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fs-title"><?php echo $question[$language]; ?></h2>
                    </div>
                </div>
                <div class="price-box">

                <div id="slider"></div>

                </div>
                <div class="options">                
                    <?php
                        for($i=1; $i<8; $i++){
                            ?>
                            <label class="relative mb-6 lg:mb-0" data-v-05d2fc82="">
                                <input type="radio" class="hidden peer" name="questionFive"  data-type="int" value="<?php echo $i; ?>" data-v-05d2fc82="">
                                <div class="flex items-center justify-between cursor-pointer square"  data-v-05d2fc82=""><?php echo $i; ?></div>
                            </label>
                            <?php
                        }
                    ?>
                </div>                    
            </div>
        </div>
    <?php
}

   function myForm($atts){

    $language= $atts['language'];
    $buttons= [
        "COL" => [
            'next' => "Siguiente",
            'previous' => "Regresar",
            'result' => "Resultados",
        ],   
        "MEX" => [
            'next' => "Siguiente",
            'previous' => "Regresar",
            'result' => "Resultados",
        ],         
        "USA" => [
            'next' => "Next",
            'previous' => "Previous",
            'result' => "Results",
        ]           
    ];

      ?>

<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11 text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <!-- <h2 id="heading">Mide tu impacto ambiental</h2> -->
    
                    <form id="msform" class="form-pricing">
    
                        <?php questionsMenu($language); ?>
       
                        <fieldset>
                            <?php questionOne($language); ?>
                            <div class="form-card">
                                <div class="col-12">
                                    
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="<?php echo $buttons[$language]['next']; ?>"/>
                        </fieldset>

                        <fieldset>
                            <div class="form-card">
                                <div class="col-12">
                                    <?php questionTwo($language); ?>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="<?php echo $buttons[$language]['next']; ?>"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="<?php echo $buttons[$language]['previous']; ?>"/>
                        </fieldset> 

                    
                        <fieldset>
                            <div class="form-card">
                                <div class="col-12">
                                    <?php questionThree($language); ?>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="<?php echo $buttons[$language]['next']; ?>"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="<?php echo $buttons[$language]['previous']; ?>"/>
                        </fieldset> 

                        <fieldset>
                            <div class="form-card">
                                <div class="col-12">
                                    <?php questionFour($language); ?>
                                </div>
                            </div>
                            <input type="button" name="next" class="next action-button" value="<?php echo $buttons[$language]['next']; ?>"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="<?php echo $buttons[$language]['previous']; ?>"/>
                        </fieldset>
                        
                        <fieldset>
                            <div class="form-card">
                                <div class="col-12">
                                    <?php questionFive($language); ?>
                                </div>
                            </div>
<<<<<<< HEAD




                            </div>
                            <input type="button" name="next" class="next action-button" value="Finalizar"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="Regresar"/>
                        </fieldset>                       



=======
                            <input type="button" name="next" class="next action-button" value="<?php echo $buttons[$language]['result']; ?>"/>
                            <input type="button" name="previous" class="previous action-button-previous" value="<?php echo $buttons[$language]['previous']; ?>"/>
                        </fieldset>
                        
                      
>>>>>>> 6c9478bde3d01c07b0e876524a1b9f77dd49969e
                        <fieldset>
                            <div class="form-card">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="fs-title">Resultados:</h2>
                                    </div>
                                </div>
                                <br><br>

                                <h2 class="col-12 text-center">Tu huella de carbono anual es dee:</h2>
                                <br>
                                <div class="row text-center">
                                    <div class="col-12">
                                    
                                        <div id="gauge"></div>

                                        <h1 text-center"><strong>1.3 toneladas</strong></h2>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <p>Tu huella de carbono anual es 79% menor que el promedio de México y 85% menor que el promedio mundial.</p>
                                        <p>¡Buen trabajo descubriendo su huella de carbono con nuestra Calculadora Lite! Para profundizar y obtener más información, consulte Calculadora avanzada.</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>



                    </form>
                </div>
            </div>
        </div>
    </div>

      <?php

   }

?>
