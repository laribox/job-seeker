@extends('layouts.app')

@section('content')

<style>
    .gradient-custom {
    /* fallback for old browsers */
    background: #6a11cb;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(
        to right,
        rgba(106, 17, 203, 1),
        rgba(37, 117, 252, 1)
    );

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(
        to right,
        rgba(106, 17, 203, 1),
        rgba(37, 117, 252, 1)
    );
}
</style>

<section class="vh-100 bg-image gradient-custom" >
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card bg-dark text-white  " id="card"  style="border-radius: 1rem;">
            <div class="card-body  p-5 ">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>

            <form id="registrationForm"  name="registrationForm"  >
                @csrf
                <div class="form-outline mb-4   ">
                    <input type="text" id="username" name="username" class="form-control form-control-lg" />
                    <label class="form-label" for="username">Company Name</label>
                    @if ($errors->has('username'))
                        <br>
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>

                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control form-control-lg" />
                    <label class="form-label" for="email">Your Email</label>
                    @if ($errors->has('email'))
                    <br>
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control form-control-lg" />
                    <label class="form-label" for="password">Password</label>
                    @if ($errors->has('password'))
                        <br>
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-outline mb-4">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control form-control-lg" />
                    <label class="form-label" for="confirmPassword">Repeat your password</label>
                    @if ($errors->has('confirmPassword'))
                        <br>
                        <span class="text-danger">{{ $errors->first('confirmPassword') }}</span>
                    @endif
                </div>

                <div class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" name="tos" value="" id="tos" />
                    <label class="form-check-label" for="form2Example3g">
                    I agree all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
                    </label>
                </div>

                <div class="d-flex justify-content-center">
                    <button   type="submit" form="registerForm" id="btnRegister"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center  mt-5 mb-0 text-light">Have already an account? <a href="{{ route('login') }}"
                    class="fw-bold text-body "><u class="text-light">Login here</u></a></p>

            </form>

            </div>
          </div>
            <div id="message"> </div>
        </div>
      </div>
    </div>
    </div>
</section>
<script>
    var url = "{{route('user.employerRegister')}}";
    document.getElementById("btnRegister").addEventListener("click", function(event) {
    var form = document.getElementById("registrationForm");
    var card = document.getElementById("card");
    var messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '';
    var formData = new FormData(form);

    var button = event.target;
    button.disabled = true;
    button.innerHTML = 'Sending email.... ';


    fetch(url, {
        method: "POST",
        headers:{
            'X-CSRF-TOKEN': '{{csrf_token()}}',
        },
        body: formData
    }).then(response => {

        if(response.ok) {
            return response.json()  ;
        }else{
            alert( 'Something went wrong. Please try again later  ')
            throw new Errror('Error')
        }
    }).then(data=> {
        button.innerHTML = 'Register'
        button.disabled = false
        messageDiv.innerHTML = '<div class="alert alert-success">Registration was successful. Please check your email to verify it</div>'
        card.style.display = 'none'
    }).catch(error => {
        button.innerHTML = 'Register'
        button.disabled = false
        messageDiv.innerHTML = '<div class="alert alert-danger">Something went wrong. Please try again later  </div>'

    })


})
</script>
@endsection
