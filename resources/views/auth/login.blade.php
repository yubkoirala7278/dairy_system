<!DOCTYPE html>
<html lang="ne">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>व्यवस्थापक लगिन</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #F3F4F6, #E3E9F0);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            background: #3E844C;
            color: white;
            padding: 1rem;
            border-radius: 15px 15px 0 0;
        }

        .logo {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            border-radius: 10px;
            background: #3E844C;
            border: none;
        }

        .btn-primary:hover {
            background: #2E6137;
        }

        .form-check-label {
            font-size: 0.9rem;
        }

        .text-center a {
            text-decoration: none;
            color: #3E844C;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        .input-group-text {
            background: #3E844C;
            color: white;
        }

        .toggle-password {
            cursor: pointer;
        }
    </style>
       <script src="https://unpkg.com/nepalify"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <!-- Company Logo -->
                        <img src="{{ asset('backend_assets/img/logo.png') }}" alt="कम्पनी लोगो" class="logo">
                        <h4>व्यवस्थापक लगिन</h4>
                    </div>
                    <div class="card-body">
                        <!-- Error Message (Optional) -->
                        @if (session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Farmer Number Field -->
                            <div class="mb-4">
                                <label for="farmer_number" class="form-label">व्यवस्थापक नम्बर</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="farmer_number"
                                        class="form-control translate-nepali @error('farmer_number') is-invalid @enderror"
                                        id="farmer_number" placeholder="आफ्नो व्यवस्थापक नम्बर प्रविष्ट गर्नुहोस्"
                                        value="{{ old('farmer_number') }}">
                                </div>
                                @if ($errors->has('farmer_number'))
                                    <span class="text-danger">{{ $errors->first('farmer_number') }}</span>
                                @endif
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <label for="password" class="form-label">पासवर्ड</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="आफ्नो पासवर्ड प्रविष्ट गर्नुहोस्">
                                    <span class="input-group-text toggle-password"><i class="fas fa-eye"></i></span>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <!-- Remember Me Checkbox -->
                            {{-- <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">मलाई सम्झनुहोस्</label>
                            </div> --}}

                            <!-- Login Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> लगिन गर्नुहोस्
                                </button>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Password Visibility
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
      {{-- language switcher --}}
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const inputs = document.querySelectorAll('.translate-nepali');

              inputs.forEach(input => {
                  input.addEventListener('input', function(event) {
                      translateToNepali(this);
                  });
              });
          });

          function translateToNepali(input) {
              const options = {
                  layout: "traditional",
              };

              // Preserve the decimal point in the value
              let translatedValue = '';
              for (let char of input.value) {
                  if (char === '.') {
                      translatedValue += char; // Keep the decimal point as is
                  } else {
                      translatedValue += nepalify.format(char, options); // Convert other characters to Nepali
                  }
              }

              // Update the input with the translated value
              input.value = translatedValue;
          }
      </script>
</body>

</html>
