<div class="row d-flex justify-content-center page-content-section">

  <div class="col-11 col-sm-9 col-md-6 col-lg-6 col-xl-4 right-font">

    <ul class="nav nav-pills nav-justified mb-3" role="tablist">
      <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'login' ? 'active' : '' ?>" id="login-pill" data-toggle="pill"
           href="#login-tab-pane" role="tab" aria-controls="login" aria-selected="true">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= $activeTab === 'signup' ? 'active' : '' ?>" id="signup-pill" data-toggle="pill"
           href="#signup-tab-pane" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
      </li>
    </ul>

    <div class="tab-content bg-darkest text-white">
      <div id="login-tab-pane" class="tab-pane fade
        <?= $activeTab === 'login' ? 'active show' : '' ?>
      " role="tabpanel" aria-labelledby="login-pill">

        <p class="text-danger">
          <?= optional($validation)->showError('loginForm') ?>
        </p>

        <?= form_open('user/login', 'id="login-form" novalidate') ?>

        <div class="form-group">
          <label for="login-name">Username/Email address</label>
          <input type="text" class="form-control text-dark <?= optional($validation)->hasError('login_name') ? 'is-invalid' : '' ?>" id="login-name" value="<?= old('login_name') ?>"
                 name="login_name" autocomplete="off" required>
          <div class="invalid-feedback">
            Enter valid username/email
          </div>
        </div>
        <div class="form-group">
          <label for="login-password">Password</label>
          <input type="password" class="form-control text-dark <?= optional($validation)->hasError('login_password') ? 'is-invalid' : '' ?>" id="login-password"
                 value="<?= old('login_password') ?>" name="login_password" autocomplete="current-password"
                 required>
          <div class="invalid-feedback">
            Enter a correct password
          </div>
        </div>
        <!-- <div class="form-group form-check">
            <label class="form-check-label" for="remember-me">Remember Me</label>
            <input type="checkbox" class="form-check-input" id="login-remember-me" name="login-remember-me" value="<?= old('login_remember_me') ?>">
          </div> -->
        <br>
        <button type="submit" class="btn btn-info">Login</button>

        <?= form_close() ?>

      </div>

      <div id="signup-tab-pane" class="tab-pane fade
        <?= $activeTab === 'signup' ? 'active show' : '' ?>
      " role="tabpanel" aria-labelledby="signup-pill">

        <p class="text-danger">
          <?= optional($validation)->showError('signupForm') ?>
        </p>

        <?= form_open('user/signup', 'id="signup-form" novalidate') ?>

        <div class="form-group">
          <label>Full Name</label>
          <div class="row">
            <div class="col-6">
              <input type="text" id="signup-firstname"
                     class="form-control text-dark <?= optional($validation)->hasError('firstname') ? 'is-invalid' : '' ?>"
                     value="<?= old('firstname') ?>" name="firstname" placeholder="First"
                     required/>
              <div class="invalid-feedback">
                Enter a valid first-name.
              </div>
            </div>
            <div class="col-6">
              <input type="text" id="signup-lastname"
                     class="form-control text-dark <?= optional($validation)->hasError('lastname') ? 'is-invalid' : '' ?>"
                     value="<?= old('lastname') ?>" name="lastname" placeholder="Last"
                     required/>
              <div class="invalid-feedback">
                Enter a valid last-name.
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="signup-username">Username (display name)</label>
          <input type="text" id="signup-username"
                 class="form-control text-dark <?= optional($validation)->hasError('username') ? 'is-invalid' : '' ?>"
                 value="<?= old('username') ?>" name="username" placeholder="Max. 20 characters"
                 maxlength="20" autocomplete="username" required/>
          <div class="valid-feedback">
            Username available!
          </div>
          <div class="invalid-feedback">
            Enter a username that doesn't already exist. It should be atmost 20 characters; consisting of
            alphanumeric (letters A-Z, numbers 0-9) or underscores (only between the alphanumeric
            characters).
          </div>
        </div>
        <div class="form-group">
          <label for="signup-email">Email</label>
          <input type="email" id="signup-email"
                 class="form-control text-dark <?= optional($validation)->hasError('email') ? 'is-invalid' : '' ?>"
                 value="<?= old('email') ?>" autocomplete="email" name="email" placeholder=""
                 required/>
          <div class="valid-feedback">
            Email is unique!
          </div>
          <div class="invalid-feedback">
            Enter a valid email that doesn't already exist.
          </div>
        </div>
        <div class="form-group">
          <label for="signup-password">Password</label>
          <div class="input-group">
            <input type="password" id="signup-password" minLength="8"
                   class="form-control text-dark <?= optional($validation)->hasError('password') ? 'is-invalid' : '' ?>"
                   value="<?= old('password') ?>" autocomplete="new-password" name="password"
                   placeholder="Min. 8 characters" required/>
            <div class="input-group-append">
              <div class="btn btn-secondary password-hidden password-visibility-toggle">
                <span class="glyphicon glyphicon-eye-open"></span>
              </div>
            </div>
            <div class="invalid-feedback">
              Enter a Password with atleast 8 characters.
            </div>
          </div>
        </div>
        <div>
          By creating an account you agree to QuePenny's <a href="#">Terms &amp; Conditions</a> and <a
                  href="#">Privacy Policy</a>.
        </div>
        <br>
        <button type="submit" class="btn btn-success">Create Account</button>

        <?= form_close() ?>

      </div>
    </div>

  </div>

</div>

<div class="modal fade <?= $emailVerified ?>" id="email-verified" tabindex="-1" aria-labelledby="email-verified"
     role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white progress-bar-striped right-font">
        <h4 class="modal-title">Email verified!</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body hind-font-700">
        <p class="mt-3">Login to begin enjoying all QuePenny benefits.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Login</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade <?= $emailUnverified ?>" id="email-unverified" tabindex="-1" aria-labelledby="email-unverified"
     role="dialog">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white progress-bar-striped right-font">
        <h4 class="modal-title">Verify your email</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body hind-font-700">
        <p class="mt-3">
          An email has been sent to you for confirmation.
          <br><br>
          Can't find it? Check your spam folder.
          <br><br>
          If not...resend?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"
                onclick="location.href='<?= site_url("user/send_email_verifier/{$username}") ?>'">Resend
        </button>
      </div>
    </div>
  </div>
</div>
