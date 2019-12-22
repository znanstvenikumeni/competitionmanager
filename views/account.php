<!doctype html>
<html lang="hr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Prijava &middot; Znanstvenik u meni</title>
  </head>
  <body>
	<nav class="navbar navbar-light bg-light card-2">
	  <a class="navbar-brand" href="/public">Znanstvenik u meni!</a>
	  
	 
	</nav>
	<div class="app-container">
		<div class="container">
			<h2 class="screen-title">Prijava</h2>
			<label for="phoneNumber">Broj mobitela</label>
			<input type="phone" id="phoneNumber" placeholder="npr. 093 123 4567" class="form-control">
		</div>
	</div>
	<nav class="navbar fixed-bottom navbar-light bg-light card-2">
  <a class="navbar-link-bottom" href="/public"><i class="material-icons">
video_library
</i></a>
  <a class="navbar-link-bottom" href="/public/search"><i class="material-icons">
search
</i></a>
  <a class="navbar-link-bottom" href="/public/account"><i class="material-icons">
account_circle
</i></a>
  <a class="navbar-link-bottom" href="/public/help"><i class="material-icons">
help
</i></a>
  <a class="navbar-link-bottom" href="https://znanstvenikumeni.org"><i class="material-icons">
public
</i></a>
</nav>
	<style>
		a:link, a:visited, a:hover, a:focus{
			color: #343a40;
		}
		.card{
			padding: 16px;
		}

.card-1 {
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.card-1:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.card-2 {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}

.card-3 {
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}

.card-4 {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.card-5 {
  box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
}

	</style>
	<body>

  <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-app.js"></script>


  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-auth.js"></script>


<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyAK8ULgPDv4BDy5kv61cyf0PIa8-U559mE",
    authDomain: "zum-competitionmanager-hr.firebaseapp.com",
    databaseURL: "https://zum-competitionmanager-hr.firebaseio.com",
    projectId: "zum-competitionmanager-hr",
    storageBucket: "zum-competitionmanager-hr.appspot.com",
    messagingSenderId: "325795873311",
    appId: "1:325795873311:web:87b088217c6bac2fbd4b2a",
    measurementId: "G-QYEN0J597E"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.auth().languageCode = 'hr';
window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sign-in-button', {
  'size': 'invisible',
  'callback': function(response) {
    // reCAPTCHA solved, allow signInWithPhoneNumber.
    onSignInSubmit();
  }
});
var phoneNumber = getPhoneNumberFromUserInput();
var appVerifier = window.recaptchaVerifier;
firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
    .then(function (confirmationResult) {
      // SMS sent. Prompt user to type the code from the message, then sign the
      // user in with confirmationResult.confirm(code).
      window.confirmationResult = confirmationResult;
    }).catch(function (error) {
      // Error; SMS not sent
      // ...
    });

</script>
</body>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>