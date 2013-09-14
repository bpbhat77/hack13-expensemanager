<?php
include 'dbc.php';
page_protect();
error_reporting(0);


?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />

  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />

  <title>Welcome to </title>
  <!-- Included CSS Files -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/foundation.css">

  <script src="js/vendor/custom.modernizr.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <script>
  $(function() {
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#shby" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            getuser.php, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );

          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
	  
	  
	  
	     $( "#paby" )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).data( "ui-autocomplete" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            availableTags, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
  });
  </script>
</head>
<body>
<?php
if (isset($_SESSION['user_id'])) {?>
<div class="row">
    <div class="large-12 columns">
		 <!-- Navigation -->

		<div class="row">
			<div class="large-12 columns">
			<nav class="top-bar">
				<ul class="title-area">
				  <!-- Title Area -->
				  <li class="name">

					  <a href="#">
						
					  </a>

				  </li>
				  
				  <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
				</ul>
         
			<section class="top-bar-section">
				  <!-- Right Nav Section -->
				<ul class="right">
					<li class="divider"></li>
					<li class="has-dropdown">
						<a href="myaccount.php">Profile</a>
						<ul class="dropdown">
							<li><a href="mysettings.php">Setting</a></li>
							
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
            </section>
          </nav>
          <!-- End Top Bar -->
        </div>
      </div>
	</div>
</div>
<!-- End Navigation -->


	
<div class="row"><!--main row -->
 
  
  
	<div class="large-12 columns">
		
		<div class="panel">
			<div class="row">

				<div class="large-4  columns">
					<h6>Welcome</h6>
				</div>
				
			</div>
		</div>
		<hr>
		<div class="panel">
			<div class="row">

				<div class="large-3  columns">
					<button id="new" class = "tiny button radius"  type="button">Create</button>
				</div>	
				<div class="large-3  columns">
					<button id="your" class = "tiny button radius" type="button">View(u)</button>
				</div>	
				<div class="large-3  columns">
					<button id="other" class = "tiny button radius" type="button">View(o)</button>
				</div>	
				<div class="large-3  columns">
					<button id="all" class = "tiny button radius" type="button">All</button>
				</div>
				
			</div>
		</div>
		<div id="newpanel" class="panel hide">
			<div class="row">

				
				<div class="large-4 columns">
					<div class="row collapse">
						<div class="small-6 columns">
							<span class="prefix radius">
								<label>Bill note </label>
							</span>
						</div>
						<div class="small-6 round columns">
								<span class="radius"><input class="round" type="text" list="end_list" placeholder=""></span>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row">

				<div class="large-4 columns">
					<div class="row collapse">
						<div class="small-6 columns">
							<span class="prefix radius">
								<label>Bill Desc </label>
							</span>
						</div>
						<div class="small-6 round columns">
								<span class="radius"><input class="round" type="text" list="end_list" placeholder=""></span>
						</div>
					</div>
				</div>
				<div class="large-4 columns">
					<div class="row collapse">
						<div class="small-6 columns">
							<span class="prefix radius">
								<label>Bill Date </label>
							</span>
						</div>
						<div class="small-6 round columns">
								<span class="radius"><input class="round" type="text" list="end_list" placeholder=""></span>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row">

				<div class="large-4 columns">
					<div class="row collapse">
						<div class="small-6 columns">
							<span class="prefix radius">
								<label>Place </label>
							</span>
						</div>
						<div class="small-6 round columns">
								<span class="radius"><input class="round" type="text" list="end_list" placeholder=""></span>
						</div>
					</div>
				</div>
				<div class="large-4 columns">
					<div class="row collapse">
						<div class="small-6 columns">
							<span class="prefix radius">
								<label>Amount </label>
							</span>
						</div>
						<div class="small-6 round columns">
								<span class="radius"><input class="round" type="text" list="end_list" placeholder=""></span>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row">

				<div class="large-5 columns">
					<div class="row collapse">
						<div class="small-8 columns">
							
								<label>Paid By </label>
							
						</div>
						<div class="small-8 pull-3 round columns">
								<span class="radius"> <textarea name="address" cols="40" rows="4" class="required" id="paby"></textarea></span>
						</div>
					</div>
				</div>
				<div class="large-5 columns">
					<div class="row collapse">
						<div class="small-8 columns">
							
								<label>Shared By </label>
							
						</div>
						<div class="small-8 pull-1 round columns">
								<span class="radius"><textarea name="address" cols="40" rows="4" class="required" id="shby"></textarea></span>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row">
			<div class="large-3 push-1   small-centered columns">
					<button id="newsubmit" class = "tiny button center radius" type="button">Submit</button>
			</div>
			</div>
		</div>
		<div id="yourpanel" class="panel hide">
			<div class="row">

				your payments
				
			</div>
			<div class="row">

				
			</div>
			<div class="row">

		
				
			</div>
			<div class="row">
			<div class="large-3 push-1   small-centered columns">
					
			</div>
			</div>
		</div>
		<div id="otherpanel" class="panel hide">
			<div class="row">

			others payment	
			</div>
			<div class="row">


				
			</div>
			<div class="row">


				
			</div>
			<div class="row">
			<div class="large-3 push-1   small-centered columns">
					
			</div>
			</div>
		</div>
		<div id="allpanel" class="panel  hide">
			<div class="row">

			ALL
				
			</div>
			<div class="row">
			<table border="0" >
  <thead>
    <tr>
      <th width="50">Billnote</th>
      <th width="50">billdate</th>
      <th width="50">Amt</th>
      <th width="50">paid</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>krishnasagar</td>
      <td>17/02</td>
      <td>2000</td>
      <td>devi</td>
    </tr>
    <tr>
      <td>kfc</td>
      <td>17/02</td>
      <td>1000</td>
      <td>ravi</td>
    </tr>
    <tr>
      <td>mecd</td>
      <td>17/02</td>
      <td>3000</td>
      <td>prashanth</td>
    </tr>
  </tbody>
</table>
				
				
			</div>
	
		</div>
		
	</div>
</div>

  <!-- Footer -->

  <footer class="row">
    <div class="large-12 columns">
      <hr />
      <div class="row">
        <div class="large-4 columns">
          <p>&copy; Copyright - Some Rights reserved </p>
        </div>
      </div>
    </div>
  </footer>
  <script src="js/foundation.min.js"></script>


  <script src="js/foundation/foundation.js"></script>

  <script src="js/foundation/foundation.alerts.js"></script>

  <script src="js/foundation/foundation.clearing.js"></script>

  <script src="js/foundation/foundation.cookie.js"></script>

  <script src="js/foundation/foundation.dropdown.js"></script>

  <script src="js/foundation/foundation.forms.js"></script>

  <script src="js/foundation/foundation.joyride.js"></script>

  <script src="js/foundation/foundation.magellan.js"></script>

  <script src="js/foundation/foundation.orbit.js"></script>

  <script src="js/foundation/foundation.reveal.js"></script>

  <script src="js/foundation/foundation.section.js"></script>

  <script src="js/foundation/foundation.tooltips.js"></script>

  <script src="js/foundation/foundation.topbar.js"></script>

  <script src="js/foundation/foundation.interchange.js"></script>

  <script src="js/foundation/foundation.placeholder.js"></script>
  
  <script>
  document.write('<script src=js/vendor/' +  ('__proto__' in {} ? 'zepto' : 'jquery') +  '.js> <\/script>');
 
  </script>
  <script src="js/foundation.min.js"></script>


 <script>
    $(document).foundation();

	$(document).ready(function() {
				$('#new').click(function() {
					$('#newpanel').fadeIn(500);
					$("#yourpanel").fadeOut(0); 
					$("#otherpanel").fadeOut(0);
					$("#allpanel").fadeOut(0);
					
				});
				$('#your').click(function() {
					$('#yourpanel').fadeIn(500);
					$("#newpanel").fadeOut(0); 
					$("#otherpanel").fadeOut(0);
					$("#allpanel").fadeOut(0);
					
				});
				$('#other').click(function() {
					$('#otherpanel').fadeIn(500);
					$("#newpanel").fadeOut(0); 
					$("#yourpanel").fadeOut(0);
					$("#allpanel").fadeOut(0);
					
				});
				$('#all').click(function() {
					$('#allpanel').fadeIn(500);
					$("#newpanel").fadeOut(0); 
					$("#yourpanel").fadeOut(0);
					$("#otherpanel").fadeOut(0);
					
					
				});
				
				
				
				
			});
  
  </script>

  
<?php } ?>
</body>
</html>
