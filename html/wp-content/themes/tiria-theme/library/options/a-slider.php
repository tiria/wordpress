<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Sliders
*****************************************************
*/

$prefix = 'slider-';

$easingOptions = array(
	'none'             => __( 'No easing', 'clifden_domain_panel' ),

	'easeInBack'       => __( 'Back In', 'clifden_domain_panel' ),
	'easeOutBack'      => __( 'Back Out', 'clifden_domain_panel' ),
	'easeInOutBack'    => __( 'Back In Out', 'clifden_domain_panel' ),

	'easeInBounce'     => __( 'Bounce In', 'clifden_domain_panel' ),
	'easeOutBounce'    => __( 'Bounce Out', 'clifden_domain_panel' ),
	'easeInOutBounce'  => __( 'Bounce In Out', 'clifden_domain_panel' ),

	'easeInCirc'       => __( 'Circ In', 'clifden_domain_panel' ),
	'easeOutCirc'      => __( 'Circ Out', 'clifden_domain_panel' ),
	'easeInOutCirc'    => __( 'Circ In Out', 'clifden_domain_panel' ),

	'easeInCubic'      => __( 'Cubic In', 'clifden_domain_panel' ),
	'easeOutCubic'     => __( 'Cubic Out', 'clifden_domain_panel' ),
	'easeInOutCubic'   => __( 'Cubic In Out', 'clifden_domain_panel' ),

	'easeInElastic'    => __( 'Elastic In', 'clifden_domain_panel' ),
	'easeOutElastic'   => __( 'Elastic Out', 'clifden_domain_panel' ),
	'easeInOutElastic' => __( 'Elastic In Out', 'clifden_domain_panel' ),

	'easeInExpo'       => __( 'Expo In', 'clifden_domain_panel' ),
	'easeOutExpo'      => __( 'Expo Out', 'clifden_domain_panel' ),
	'easeInOutExpo'    => __( 'Expo In Out', 'clifden_domain_panel' ),

	'easeInQuad'       => __( 'Quad In', 'clifden_domain_panel' ),
	'easeOutQuad'      => __( 'Quad Out', 'clifden_domain_panel' ),
	'easeInOutQuad'    => __( 'Quad In Out', 'clifden_domain_panel' ),

	'easeInQuart'      => __( 'Quart In', 'clifden_domain_panel' ),
	'easeOutQuart'     => __( 'Quart Out', 'clifden_domain_panel' ),
	'easeInOutQuart'   => __( 'Quart In Out', 'clifden_domain_panel' ),

	'easeInQuint'      => __( 'Quint In', 'clifden_domain_panel' ),
	'easeOutQuint'     => __( 'Quint Out', 'clifden_domain_panel' ),
	'easeInOutQuint'   => __( 'Quint In Out', 'clifden_domain_panel' ),

	'easeInSine'       => __( 'Sine In', 'clifden_domain_panel' ),
	'easeOutSine'      => __( 'Sine Out', 'clifden_domain_panel' ),
	'easeInOutSine'    => __( 'Sine In Out', 'clifden_domain_panel' )
);

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "slider",
	"title" => __( 'Sliders', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "slider",
		"list" => array(
			__( 'Basics', 'clifden_domain_panel' ),
			__( 'Flex', 'clifden_domain_panel' ),
			__( 'Nivo', 'clifden_domain_panel' ),
			__( 'Roundabout', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "slider-1",
		"title" => __( 'Basics', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'General slider settings', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "slider",
			"id" => $prefix."max-number",
			"label" => __( 'Maximum number of slides', 'clifden_domain_panel' ),
			"desc" => __( 'Sets the maximum number of slides (note that more slides in slider means longer time to load the page)', 'clifden_domain_panel' ),
			"default" => 10,
			"min" => 1,
			"max" => 50,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."custom-remove",
			"label" => __( 'Remove custom slider from selection', 'clifden_domain_panel' ),
			"desc" => __( 'Custom slider option in page slider selection will let you insert any slider effect (if you use 3rd party slider plugins) into main slider area using shortcode.<br />By default this option is used to display <strong>Revolution Slider</strong> which is included with the theme as a plugin (you will have to install it first).', 'clifden_domain_panel' ),
			"value" => "true"
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "slider-2",
		"title" => __( 'Flex', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Flex Slider customization', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."flex-"."remove",
			"label" => __( 'Remove from slider selection', 'clifden_domain_panel' ),
			"desc" => __( 'Removes this slider from slider selection in Page settings metabox', 'clifden_domain_panel' ),
			"value" => "true"
		),
		array(
			"type" => "space"
		),

		array(
			"type" => "info",
			"content" => __( 'Flex slider is <strong>simple, resource easy</strong>, yet very flexible slideshow. <strong>Does not display videos. Does not stretch images forcefully</strong> when displayed throughout the full website width. <strong>Adapts to different image heights</strong> automatically.', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "space"
		),

		array(
			"type" => "slider",
			"id" => $prefix."flex-"."slideshowSpeed",
			"label" => __( 'Slide display time', 'clifden_domain_panel' ),
			"desc" => __( 'Time of slide being displayed (in miliseconds)', 'clifden_domain_panel' ),
			"default" => 6000,
			"min" => 500,
			"max" => 12000,
			"step" => 250,
			"validate" => "absint"
		),
		array(
			"type" => "slider",
			"id" => $prefix."flex-"."animationSpeed",
			"label" => __( 'Transition speed', 'clifden_domain_panel' ),
			"desc" => __( 'Speed of transition effect between slides (in miliseconds)', 'clifden_domain_panel' ),
			"default" => 600,
			"min" => 50,
			"max" => 2000,
			"step" => 50,
			"validate" => "absint"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."flex-"."pauseOnHover",
			"label" => __( 'Pause on hover', 'clifden_domain_panel' ),
			"desc" => __( 'Pause the slideshow while hovering over slider', 'clifden_domain_panel' ),
			"value" => "true",
			"default" => "true"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."flex-"."pauseOnAction",
			"label" => __( 'Pause on action', 'clifden_domain_panel' ),
			"desc" => __( 'Pause the slideshow when interacting with control elements', 'clifden_domain_panel' ),
			"value" => "true",
			"default" => "true"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "select",
			"id" => $prefix."flex-"."animation",
			"label" => __( 'Animation effect', 'clifden_domain_panel' ),
			"desc" => __( 'Choose slider animation effect', 'clifden_domain_panel' ),
			"options" => array(
				'fade'  => __( 'Fading effect', 'clifden_domain_panel' ),
				'slide' => __( 'Sliding effect', 'clifden_domain_panel' )
				),
			"default" => "slide"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "checkbox",
			"id" => $prefix."flex-"."controlNav",
			"label" => __( 'Disable control buttons', 'clifden_domain_panel' ),
			"desc" => __( 'Do not use slideshow control buttons', 'clifden_domain_panel' ),
			"value" => "false"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."flex-"."directionNav",
			"label" => __( 'Disable direction buttons', 'clifden_domain_panel' ),
			"desc" => __( 'Do not use prev/next buttons', 'clifden_domain_panel' ),
			"value" => "false"
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "slider-3",
		"title" => __( 'Nivo', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Nivo Slider customization', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."nivo-"."remove",
			"label" => __( 'Remove from slider selection', 'clifden_domain_panel' ),
			"desc" => __( 'Removes this slider from slider selection in Page settings metabox', 'clifden_domain_panel' ),
			"value" => "true"
		),
		array(
			"type" => "space"
		),

		array(
			"type" => "info",
			"content" => __( 'Nivo slider offers a <strong>lot of animation effects and flexibility</strong> but <strong>does not display videos</strong>. Stretches images to fit either content width or full website width (depends on slider settings on specific page). <strong>Using transparent or partially transparent images is not recommended. Adapts to different image heights</strong> automatically.', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "space"
		),

		array(
			"type" => "slider",
			"id" => $prefix."nivo-"."pauseTime",
			"label" => __( 'Slide display time', 'clifden_domain_panel' ),
			"desc" => __( 'Time of slide being displayed (in miliseconds)', 'clifden_domain_panel' ),
			"default" => 6000,
			"min" => 500,
			"max" => 12000,
			"step" => 250,
			"validate" => "absint"
		),
		array(
			"type" => "slider",
			"id" => $prefix."nivo-"."animSpeed",
			"label" => __( 'Transition speed', 'clifden_domain_panel' ),
			"desc" => __( 'Speed of transition effect between slides (in miliseconds)', 'clifden_domain_panel' ),
			"default" => 600,
			"min" => 50,
			"max" => 2000,
			"step" => 50,
			"validate" => "absint"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."nivo-"."pauseOnHover",
			"label" => __( 'Pause on hover', 'clifden_domain_panel' ),
			"desc" => __( 'Stops animation on mouse hover', 'clifden_domain_panel' ),
			"value" => "true",
			"default" => "true"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "select",
			"id" => $prefix."nivo-"."effect",
			"label" => __( 'Animation effect', 'clifden_domain_panel' ),
			"desc" => __( 'Choose slider animation effect', 'clifden_domain_panel' ),
			"options" => array(
				'sliceDown'          => __( 'Slice down', 'clifden_domain_panel' ),
				'sliceDownLeft'      => __( 'Slice down (right to left)', 'clifden_domain_panel' ),
				'sliceUp'            => __( 'Slice up', 'clifden_domain_panel' ),
				'sliceUpLeft'        => __( 'Slice up (right to left)', 'clifden_domain_panel' ),
				'sliceUpDown'        => __( 'Slice up and down', 'clifden_domain_panel' ),
				'sliceUpDownLeft'    => __( 'Slice up and down (right to left)', 'clifden_domain_panel' ),
				'fold'               => __( 'Folding', 'clifden_domain_panel' ),
				'fade'               => __( 'Fading', 'clifden_domain_panel' ),
				'slideInRight'       => __( 'Slide in', 'clifden_domain_panel' ),
				'slideInLeft'        => __( 'Slide in from right', 'clifden_domain_panel' ),
				'boxRain'            => __( 'Rain', 'clifden_domain_panel' ),
				'boxRainReverse'     => __( 'Rain reverse', 'clifden_domain_panel' ),
				'boxRainGrow'        => __( 'Rain grow', 'clifden_domain_panel' ),
				'boxRainGrowReverse' => __( 'Rain grow reverse', 'clifden_domain_panel' ),
				'boxRandom'          => __( 'Random boxes', 'clifden_domain_panel' ),
				'random'             => __( 'Random', 'clifden_domain_panel' )
				),
			"default" => "sliceDown"
		),
		array(
			"type" => "slider",
			"id" => $prefix."nivo-"."slices",
			"label" => __( 'Slices count', 'clifden_domain_panel' ),
			"desc" => __( 'Number of slices for "Slice" animations', 'clifden_domain_panel' ),
			"default" => 8,
			"min" => 1,
			"max" => 16,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "slider",
			"id" => $prefix."nivo-"."boxCols",
			"label" => __( 'Box columns count', 'clifden_domain_panel' ),
			"desc" => __( 'Horizontal number of boxes for "Rain" and "Boxes" animations', 'clifden_domain_panel' ),
			"default" => 8,
			"min" => 1,
			"max" => 16,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "slider",
			"id" => $prefix."nivo-"."boxRows",
			"label" => __( 'Box rows count', 'clifden_domain_panel' ),
			"desc" => __( 'Vertical number of boxes for "Rain" and "Boxes" animations', 'clifden_domain_panel' ),
			"default" => 4,
			"min" => 1,
			"max" => 12,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "checkbox",
			"id" => $prefix."nivo-"."controlNav",
			"label" => __( 'Enable control buttons', 'clifden_domain_panel' ),
			"desc" => __( 'Use slideshow control buttons', 'clifden_domain_panel' ),
			"value" => "true"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."nivo-"."directionNav",
			"label" => __( 'Disable direction buttons', 'clifden_domain_panel' ),
			"desc" => __( 'Do not use prev/next buttons', 'clifden_domain_panel' ),
			"value" => "false"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."nivo-"."directionNavHide",
			"label" => __( 'Hide direction buttons', 'clifden_domain_panel' ),
			"desc" => __( 'Displays prev/next buttons on mouse hover only', 'clifden_domain_panel' ),
			"value" => "true",
			"default" => "true"
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "slider-5",
		"title" => __( 'Roundabout', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Roundabout Slider customization', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."roundabout-"."remove",
			"label" => __( 'Remove from slider selection', 'clifden_domain_panel' ),
			"desc" => __( 'Removes this slider from slider selection in Page settings metabox', 'clifden_domain_panel' ),
			"value" => "true"
		),
		array(
			"type" => "space"
		),

		array(
			"type" => "info",
			"content" => __( 'Roundabout slider displays slides in <strong>3D carousel. Does not display slide caption but displays videos.</strong>', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "space"
		),

		array(
			"type" => "slider",
			"id" => $prefix."roundabout-"."autoplayDuration",
			"label" => __( 'Slide display time', 'clifden_domain_panel' ),
			"desc" => __( 'Time of slide being displayed (in miliseconds)', 'clifden_domain_panel' ),
			"default" => 6000,
			"min" => 500,
			"max" => 12000,
			"step" => 250,
			"validate" => "absint"
		),
		array(
			"type" => "slider",
			"id" => $prefix."roundabout-"."duration",
			"label" => __( 'Transition speed', 'clifden_domain_panel' ),
			"desc" => __( 'Speed of transition effect between slides (in miliseconds)', 'clifden_domain_panel' ),
			"default" => 600,
			"min" => 50,
			"max" => 2000,
			"step" => 50,
			"validate" => "absint"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."roundabout-"."autoplayPauseOnHover",
			"label" => __( 'Pause on mouse hover', 'clifden_domain_panel' ),
			"desc" => __( 'Stops the automatic rotation on mouse hover', 'clifden_domain_panel' ),
			"value" => "true",
			"default" => "true"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."roundabout-"."reflect",
			"label" => __( 'Switch direction', 'clifden_domain_panel' ),
			"desc" => __( 'Changes automatic rotation direction (left to right)', 'clifden_domain_panel' ),
			"value" => "true"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "select",
			"id" => $prefix."roundabout-"."shape",
			"label" => __( 'Animation effect', 'clifden_domain_panel' ),
			"desc" => __( 'Choose slider animation effect', 'clifden_domain_panel' ),
			"options" => array(
				'lazySusan'         => __( 'Lazy Susan', 'clifden_domain_panel' ),
				//'waterWheel'      => __( 'Water Wheel', 'clifden_domain_panel' ),
				'figure8'           => __( 'Figure 8', 'clifden_domain_panel' ),
				'square'            => __( 'Square', 'clifden_domain_panel' ),
				//'conveyorBeltLeft'  => __( 'Conveyor Belt (Left)', 'clifden_domain_panel' ),
				//'conveyorBeltRight' => __( 'Conveyor Belt (Right)', 'clifden_domain_panel' ),
				'diagonalRingLeft'  => __( 'Diagonal Ring (Left)', 'clifden_domain_panel' ),
				'diagonalRingRight' => __( 'Diagonal Ring (Right)', 'clifden_domain_panel' ),
				'rollerCoaster'     => __( 'Roller Coaster', 'clifden_domain_panel' ),
				'tearDrop'          => __( 'Tear Drop', 'clifden_domain_panel' ),
				//'theJuggler'        => __( 'The Juggler', 'clifden_domain_panel' ),
				//'goodbyeCruelWorld' => __( 'Goodbye Cruel World', 'clifden_domain_panel' )
				),
			"default" => "lazySusan"
		),
		array(
			"type" => "select",
			"id" => $prefix."roundabout-"."easing",
			"label" => __( 'Easing effect', 'clifden_domain_panel' ),
			"desc" => __( 'Choose Roundabout slider easing effect', 'clifden_domain_panel' ),
			"options" => $easingOptions,
			"default" => "easeOutCirc"
		),
		array(
			"type" => "slider",
			"id" => $prefix."roundabout-"."minOpacity",
			"label" => __( 'The backmost slide opacity', 'clifden_domain_panel' ),
			"desc" => __( 'Sets the lowest opacity of slides in the background in % against frontmost slide', 'clifden_domain_panel' ),
			"default" => 40,
			"min" => 5,
			"max" => 100,
			"step" => 5,
			"validate" => "absint"
		),
		array(
			"type" => "slider",
			"id" => $prefix."roundabout-"."minScale",
			"label" => __( 'The backmost slide size', 'clifden_domain_panel' ),
			"desc" => __( 'Sets the smallest size of slides in the background in % against frontmost slide', 'clifden_domain_panel' ),
			"default" => 40,
			"min" => 5,
			"max" => 100,
			"step" => 5,
			"validate" => "absint"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "checkbox",
			"id" => $prefix."roundabout-"."enableDrag",
			"label" => __( 'Enable dragging', 'clifden_domain_panel' ),
			"desc" => __( 'Allows controlling the animation by dragging slides on touch screens', 'clifden_domain_panel' ),
			"value" => "true",
			"default" => "true"
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "slider",
			"id" => $prefix."roundabout-"."dropDuration",
			"label" => __( 'Dragging transition speed', 'clifden_domain_panel' ),
			"desc" => __( 'Speed of transitioning between slides (in miliseconds) when dragging', 'clifden_domain_panel' ),
			"default" => 600,
			"min" => 50,
			"max" => 2000,
			"step" => 50,
			"validate" => "absint"
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),

array(
	"type" => "section-close"
)

);

?>