<!-- Header Section -->
<header class="header">
    <div class="left-header">
        <div class="menu-btn">
            <svg class="hb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" stroke="#eee" stroke-width=".6"
                fill="rgba(0,0,0,0)" stroke-linecap="round" style="cursor: pointer">
                <path d="M2,3L5,3L8,3M2,5L8,5M2,7L5,7L8,7">
                    <animate dur="0.2s" attributeName="d"
                        values="M2,3L5,3L8,3M2,5L8,5M2,7L5,7L8,7;M3,3L5,5L7,3M5,5L5,5M3,7L5,5L7,7" fill="freeze"
                        begin="start.begin" />
                    <animate dur="0.2s" attributeName="d"
                        values="M3,3L5,5L7,3M5,5L5,5M3,7L5,5L7,7;M2,3L5,3L8,3M2,5L8,5M2,7L5,7L8,7" fill="freeze"
                        begin="reverse.begin" />
                </path>
                <rect width="10" height="10" stroke="none">
                    <animate dur="2s" id="reverse" attributeName="width" begin="click" />
                </rect>
                <rect width="10" height="10" stroke="none">
                    <animate dur="0.001s" id="start" attributeName="width" values="10;0" fill="freeze" begin="click" />
                    <animate dur="0.001s" attributeName="width" values="0;10" fill="freeze" begin="reverse.begin" />
                </rect>
            </svg>
        </div>
        <div class="logo"><a href="/">Emulate</a></div>
        <nav>
            <ul class="nav-links">
                <li><a href="{{route('products.index')}}">Products</a></li>
                <li><a href="{{route('buyer.celeb')}}">Creators</a></li>
                <li><a href="{{route('product.rent')}}">Rental</a></li>
                <li><a href="{{route('product.buy')}}">Purchase</a></li>
                <li><a href="#">About Us</a></li>
                <li onclick="toggleSearch()"><i class="fa-solid fa-magnifying-glass"></i></li>
            </ul>
        </nav>
    </div>
    <style>
        .search-overlay {
          position: absolute;
          top: 0;
          left: 100%;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.9);
          display: flex;
          align-items: center;
          justify-content: center;
          transition: opacity 0.5s, left 0.7s;
          opacity: 0;
          visibility: hidden;
        }
        
        .search-overlay.active {
          left:0;
          opacity: 1;
          visibility: visible;
        }
        
        .search-overlay .search-input {
          width: 98%;
          padding: 15px;
          font-size: 1.2em;
          border: none;
          outline: none;
          background-color: #444;
          color: #fff;
          border-radius: 5px;
        }
        
        .search-overlay .close-btn {
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          right: 20px;
          font-size: 1.5em;
          cursor: pointer;
          background: none;
          border: none;
          color: #fff;
        }
    </style>
    <form action="{{ route('search') }}" method="GET">
        <div class="search-overlay" id="searchOverlay">
            <button class="close-btn" onclick="toggleSearch()">✖</button>
        <input type="text" name="query" class="search-input" placeholder="Type to search...">
        </div>
    </form>
    <div class="header-buttons">
        @auth
            @if(auth()->user()->role == 'seller' || auth()->user()->role == 'admin')
                <button style="background: black;border: none;color: white; cursor:pointer;" onclick="window.location.href='{{ route('seller.front') }}'"><i class="fa-solid fa-user"></i></button>
                <div style="display:flex;align-items:center;justify-content:center">
                <span style="margin-right:5px"> Hy! </span> <span style="margin-left:5px">{{auth()->user()->name }}</span> 
                </div>
            @endif  
            @if(auth()->user()->role == 'buyer' || auth()->user()->role == 'admin')
                <button class="cart-btn" onclick="openPopup('wishlist')"><i class="fa-regular fa-heart"></i></button>
            @endif
                <button class="cart-btn" id="cartButton"><i class="fa-solid fa-bag-shopping"></i></button>
            @if(auth()->user()->role == 'buyer')
                <button class="settings-btn" id="settingsButton" onclick="window.location.href='{{ route('buyer.settings') }}'"><i class="fa-solid fa-user"></i></button>
                <div style="display:flex;align-items:center;justify-content:center">
                    <span style="margin-right:5px"> Hy! </span> <span style="margin-left:5px">{{auth()->user()->name }}</span> 
                </div>
            @endif    
        @endauth

        @if(Auth::check())
            @if(auth()->user()->role == 'seller' || auth()->user()->role == 'admin')
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sign-in-btn rounded-btn">Logout</button>
                </form>
            @endif
        @else
            <button class="sign-in-btn rounded-btn" onclick="openPopup('signin')">Sign In</button>
        @endif
    </div>
</header>



<!-- Sign In Popup -->
<div id="signin-popup" class="popup">
    <div class="popup-content">
        <div class="popup-title">
            <h3>Sign In </h3>
            <div class="signin-link">
                <span>Don't have an account? <button onclick="closePopup('signin'); openPopup('signup');">Sign Up</button></span>
            </div>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('signin')">X</span></div>
        </div>
        <div class="popup-form-container">
            <form class="popup-form" method="POST" action="{{ route('login') }}">
                @csrf
                <label for="email">{{ __('Email Address') }}</label>
                <input type="email" id="email"  name="email"
                    value="{{ old('email') }}"  autocomplete="email" autofocus>


                <label for="password">{{ __('Password') }}</label>
                <input type="password" id="password" class="form-control"
                    name="password"  autocomplete="current-password">


                <button  type="submit">SIGN IN</button>
            </form>
            <p class="login-statment">
                By logging in, you are agreeing to the Terms of Service and confirm that you have read the
                Privacy Policy.
            </p>

            <div class="or-divider">or</div>

            <a href="{{ url('auth/google') }}">
                <div class="google-btn">
                    <svg viewBox="0 0 48 48">
                        <title>Google Logo</title>
                        <clipPath id="g">
                            <path
                                d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                        </clipPath>
                        <g class="colors" clip-path="url(#g)">
                            <path fill="#FBBC05" d="M0 37V11l17 13z" />
                            <path fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                            <path fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                            <path fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                        </g>
                    </svg>
                    Continue with Google
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Seller Sign Up Popup -->
<div id="sellerSignup-popup" class="popup">
    <div class="popup-content">
        <div class="popup-title">
            <h3>Seller Sign Up</h3>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('sellerSignup')">X</span></div>
        </div>
        <div class="popup-form-container">
            <form class="popup-form seller-register-form" method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role" value="seller">
                <label for="email">{{ __('Email Address') }}</label>
                <input type="email" id="email" class="@error('email') is-invalid @enderror" name="email"
                    value="{{ $email ?? old('email') }}"  autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="password">{{ __('Password') }}</label>
                <input type="password" id="password" class="@error('password') is-invalid @enderror" name="password"
                     autocomplete="current-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror


                <label for="name">Username</label>
                <input type="text" id="name" class="@error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}"  autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <button type="submit">SIGN UP</button>
            </form>
        </div>
    </div>
</div>


<!-- Sign Up Popup -->
<div id="signup-popup" class="popup">
    <div class="popup-content" style="width: 100%;">
        <div class="popup-title">
            <h3>Sign Up</h3>

            <div class="signin-link" style="display: flex;gap: 1.5em;">
                <span>Don't have an account? <button onclick="closePopup('signup'); openPopup('signin');">SignIn</button></span>
                <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('signup')">X</span></div>
            </div>
        </div>
        <div class="popup-form-container">
            <form class="register-form popup-form" method="POST" action="{{ route('register') }}">
                @csrf
                <label for="email">{{ __('Email Address') }}</label>
                <input type="email" id="email" class="@error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" autocomplete="email">
                <div>
                    <span class="email-error invalid-feedback" style="color:red;margin-bottom:2px;" role="alert"></span>
                </div>



                <label for="name">Username</label>
                <input type="text" id="name" class="@error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" autocomplete="name" autofocus>
                <div>
                    <span class="name-error invalid-feedback " style="color:red;margin-bottom:2px;" role="alert"></span>
                </div>



                <label for="password">{{ __('Password') }}</label>
                <input type="password" id="password" class="@error('password') is-invalid @enderror" name="password"
                    autocomplete="current-password">
                <div>
                    <span class="password-error invalid-feedback" style="color:red;margin-bottom:2px;"
                        role="alert"></span>
                </div>



                <button type="submit">SIGN UP</button>
            </form>

            <div class="or-divider">or</div>

            <a  href="{{ url('auth/google') }}">
                <div class="google-btn">
                    <svg viewBox="0 0 48 48">
                        <title>Google Logo2</title>
                        <clipPath id="g2">
                            <path
                                d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                        </clipPath>
                        <g class="colors" clip-path="url(#g2)">
                            <path fill="#FBBC05" d="M0 37V11l17 13z" />
                            <path fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                            <path fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                            <path fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                        </g>
                    </svg>
                    Continue with Google
                </div>
            </a>
        </div>
    </div>
</div>


<!-- Sidebar for menu -->
<div class="menu-sidebar" id="menuSidebar">
    <div class="logo"  style="display:flex;justify-content:space-between;">
        <div>Emulate</div> 
        
        <div onclick="toggleSearch()"><i class="fa-solid fa-magnifying-glass"></i></div>
    </div>
    <ul style="display:flex;flex-direction:column;">
                <li><a href="{{route('products.index')}}">Products</a></li>
                <li><a href="{{route('buyer.celeb')}}">Creators</a></li>
                <li><a href="{{route('product.rent')}}">Rental</a></li>
                <li><a href="{{route('product.buy')}}">Purchase</a></li>
                <li><a href="#">About Us</a></li>
    </ul>
</div>

<!-- wishlist popup  -->
<div id="wishlist-popup" class="popup">
    <div class="popup-content" style="width:85% !important;">
        <div class="popup-title">
            <h3>Your Wishlist</h3>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('wishlist')">X</span></div>
        </div>
        <div class="popup-form-container">
            <form class="popup-form">
                
            </form>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Load the Visualization API and the corechart and bar packages.
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });

    // Draw the Donut chart (Active now)
    google.charts.setOnLoadCallback(drawDonutChart);

    function drawDonutChart() {
        var data = google.visualization.arrayToDataTable([
            ['Status', 'Count'],
            ['Active', 316],
            ['Inactive', 1000]
        ]);

        var options = {
            pieHole: 0.5,
            colors: ['#000000', '#d3d3d3'],
            legend: 'none',
            pieSliceText: 'none',
            pieStartAngle: 100,
            chartArea: {
                width: '100%',
                height: '80%'
            },
            backgroundColor: '#f5f5f5',
        };

        var chart = new google.visualization.PieChart(document.getElementById('donut_chart'));
        chart.draw(data, options);
    }

    // Draw the Line chart (Total Customers)
    google.charts.setOnLoadCallback(drawLineChart);

    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Month', 'Customers'],
            ['Jan', 1000],
            ['Feb', 1170],
            ['Mar', 660],
            ['Apr', 1030],
            ['May', 1230],
            ['Jun', 1460],
            ['Jul', 1690],
            ['Aug', 1860]
        ]);

        var options = {
            colors: ['#000000'],
            backgroundColor: '#f5f5f5',
            legend: 'none',
            chartArea: {
                width: '80%',
                height: '80%'
            },
            hAxis: {
                title: 'Month'
            },
            vAxis: {
                title: 'Customers'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        chart.draw(data, options);
    }

    // Draw the Stacked Bar chart (How do you acquire users?)
    google.charts.setOnLoadCallback(drawBarChart);

    function drawBarChart() {
        var data = google.visualization.arrayToDataTable([
            ['Source', 'Direct', 'Referral', 'Social'],
            ['Mon', 1000, 400, 200],
            ['Tue', 1170, 460, 250],
            ['Wed', 660, 1120, 300],
            ['Thu', 1030, 540, 350],
            ['Fri', 900, 550, 400]
        ]);

        var options = {
            isStacked: true,
            backgroundColor: '#f5f5f5',
            colors: ['#000000', '#777777', '#d3d3d3'],
            legend: 'none',
            chartArea: {
                width: '80%',
                height: '80%'
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
        chart.draw(data, options);
    }
</script>
<script>
    function checkURLParams() {
        const params = new URLSearchParams(window.location.search);
        const email = params.get('email');
        const modal = params.get('modal');

        if (email && modal === 'true') {
            document.getElementById('email').value = email;
            openPopup('sellerSignup');
        }
    }

    document.addEventListener('DOMContentLoaded', checkURLParams);
</script>

<!-- for buyer signup  -->
<script>
    document.querySelector('.register-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const emailError = document.querySelector('.email-error');
        const nameError = document.querySelector('.name-error');
        const passwordError = document.querySelector('.password-error');

        emailError.textContent = '';
        nameError.textContent = '';
        passwordError.textContent = '';

        fetch('{{ route('register') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else if (data.errors) { 
                    if (data.errors.email) {
                        emailError.textContent = data.errors.email[0];
                    }
                    if (data.errors.name) {
                        nameError.textContent = data.errors.name[0];
                    }
                    if (data.errors.password) {
                        passwordError.textContent = data.errors.password[0];
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
<!-- for buyer signup end  -->

<!-- script for sign in  -->
<script>
    document.querySelector('.popup-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            toastr.error('All fields are required.', 'Error', {
                positionClass: 'toast-top-right',
                timeOut: 3000
            });
            return;
        }

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                toastr.error('Invalid credentials.', 'Error', {
                    positionClass: 'toast-top-right',
                    timeOut: 3000
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
<!-- script for sign in end -->

<script>
    document.querySelector('.seller-register-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const emailError = document.querySelector('.email-error');
        const nameError = document.querySelector('.name-error');
        const passwordError = document.querySelector('.password-error');

        console.log(formData);

        emailError.textContent = '';
        nameError.textContent = '';
        passwordError.textContent = '';

        fetch('{{ route('register') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                }else if (data.errors) { 

                    Object.keys(data.errors).forEach(function (key) {
                        toastr.error(data.errors[key][0]);
                    });

                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>

<script>
    function openPopup(type) {
        document.getElementById(`${type}-popup`).classList.add("open");
        overlay.style.display = "block";
    }


    function closePopup(popupId) {
        document.getElementById(`${popupId}-popup`).classList.remove("open");
        overlay.style.display = "none";
    }
    
    function toggleSearch() {
      const searchOverlay = document.getElementById('searchOverlay');
      searchOverlay.classList.toggle('active');
    }
</script>

<script>
     
    const menuSidebar = document.getElementById("menuSidebar");
    const svgElement = document.querySelector(".hb");

    // Open sidebar and show overlay when menu button is clicked
    svgElement.addEventListener("click", () => {
    // Check the current position of the sidebar
    if (menuSidebar.style.right === "0px") {
        // Close the sidebar and hide the overlay
        menuSidebar.style.right = "-100%";
        overlay.style.display = "none";

        // Trigger the SVG reverse animation
        const reverseAnimation = document.getElementById("reverse");
        reverseAnimation.beginElement();
    } else {
        // Open the sidebar and show the overlay
        menuSidebar.style.right = "0";
        overlay.style.display = "block";

        // Trigger the SVG opening animation
        const startAnimation = document.getElementById("start");
        startAnimation.beginElement();
    }
    });
 </script>
