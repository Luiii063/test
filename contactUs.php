<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style/landingpage.css">
    <style>
   @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap");

* {
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  margin: 0;
  padding: 0;
  scroll-behavior: smooth;
}

    body {
    background: linear-gradient(#2b1055, #7597de);
    min-height: 100vh;
    overflow-x: hidden;
    }

* {
  scrollbar-color: #fff transparent;
}

::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #1c0522;
}

::-webkit-scrollbar-thumb {
  background: #fff;
}

/*===== Responsive Mobile View =====*/

@media screen and (max-width: 650px) {
  .header {
    justify-content: center;
  }

  .nav {
    display: none;
  }
}
.home-section {
  position: relative;
  height: 100vh;
  width: 100%;
  padding: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.home-section:before {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  height: 100px;
  width: 100%;
  background: linear-gradient(to top, #1c0522, transparent);
  z-index: 1000;
}

.home-section img {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  object-fit: cover;
  pointer-events: none;
}

.home-section img#moon {
  mix-blend-mode: screen;
}

.home-section img#mountains_front {
  z-index: 10;
}

        .navbar-brand {
            margin-right: auto;
        }

        .navbar-nav {
            text-align: center;
            margin-top: 10px;
        }

        .nav-item {
            margin-left: 10px;
        }

        header {
            text-align: center;
            max-width: 1500px;
            margin: 15px auto;
        }

        .content {
            text-align: center;
            padding: 50px 0;
            max-width: 1500px;
            margin: 50px 0;
            height: 800px;
        }

        .apply-button {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
        }

        .button-app {
            text-decoration: none;
            position: relative;
            border: none;
            font-size: 14px;
            font-family: sans-serif;
            color: #fff;
            width: 70px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            background: linear-gradient(90deg, blue, #ffffff, #fff1f1, blue);
            background-size: 300%;
            border-radius: 30px;
            z-index: 1;
            margin: 0 10px 0 20px;
        }

        .button-app:hover {
            animation: ani 8s linear infinite;
            border: none;
            color: white;
            text-decoration: none;
        }

        @keyframes ani {
            0% {
                background-position: 0%;
            }

            100% {
                background-position: 400%;
            }
        }

        .button-app:before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            z-index: -1;
            background: linear-gradient(90deg, #abbbee, #5b6bff, #1541d3, blue);
            background-size: 400%;
            border-radius: 35px;
            transition: 1s;
        }

        .button-app:hover::before {
            filter: blur(20px);
        }

        .button-app:active {
            background: linear-gradient(32deg, #fafdff, #1900ff, #ffffff, #0313f4);
        }
        .input-container {
            position: relative;
            display: flex;
            align-items: center;
            top: -5px;
            margin-left: 10px;
          }
          
          .input {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            outline: none;
            padding: 18px 16px;
            background-color: transparent;
            cursor: pointer;
            transition: all .5s ease-in-out;
          }
          
          .input::placeholder {
            color: transparent;
          }
          
          .input:focus::placeholder {
            color: rgb(131, 128, 128);
          }
          
          .input:focus,.input:not(:placeholder-shown) {
            background-color: #fff;
            border: 1px solid rgb(71, 71, 71);
            width: 290px;
            cursor: none;
            padding: 18px 16px 18px 40px;
          }
          
          .input-icon {
            position: absolute;
            left: 0;
            top: 0;
            height: 40px;
            width: 40px;
            background-color: #fff;
            border-radius: 10px;
            z-index: -1;
            fill: #007bff;
            border: 1px solid rgb(0, 102, 255);
          }
          
          .input:hover + .input-icon {
            transform: rotate(360deg);
            transition: .2s ease-in-out;
          }
          
          .input:focus + .input-icon,.input:not(:placeholder-shown) + .input-icon {
            z-index: 0;
            background-color: transparent;
            border: none;
          }
          

        @media (max-width: 768px) {
            .navbar-nav {
                float: none;
                text-align: center;
                margin-top: 10px;
            }

            .navbar-toggler {
                margin-top: 5px;
            }
			.navbar-expand-lg .navbar-nav {
				flex-direction: column;
			}

            .button-app {
                display: block;
                width: auto;
                margin: 5px;
                padding: 5px 15px;
            }

            .content {
                padding: 20px;
            }

            .left-content1, .left-content2 {
                margin: 10px 0;
            }

            .icon {
                flex-direction: column;
                gap: 10px;
            }

            .icon p {
                font-size: 20px;
            }

            .carousel-inner img {
                height: auto;
                max-width: 100%;
            }
			h1{
				font-size:30px;
			}
            .container {
                max-width: 1140px;
            }
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <img src="images/unlad.png" alt="Logo 1" width="90" height="70">
        <a class="scholar" href="#"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="button-app" href="landing_page.php">Home</a>
                <a class="button-app" href="about.php">About</a>
                <a class="button-app" href="contactUs.php">Contact Us</a>
                <a class="button-app" href="login.php">Log In</a>
                <a class="button-app" href="registration.php">Register</a>
                <div class="input-container">
    <input placeholder="Search something..." class="input" name="text" type="text">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="input-icon"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <rect fill="white"></rect> <path d="M7.25007 2.38782C8.54878 2.0992 10.1243 2 12 2C13.8757 2 15.4512 2.0992 16.7499 2.38782C18.06 2.67897 19.1488 3.176 19.9864 4.01358C20.824 4.85116 21.321 5.94002 21.6122 7.25007C21.9008 8.54878 22 10.1243 22 12C22 13.8757 21.9008 15.4512 21.6122 16.7499C21.321 18.06 20.824 19.1488 19.9864 19.9864C19.1488 20.824 18.06 21.321 16.7499 21.6122C15.4512 21.9008 13.8757 22 12 22C10.1243 22 8.54878 21.9008 7.25007 21.6122C5.94002 21.321 4.85116 20.824 4.01358 19.9864C3.176 19.1488 2.67897 18.06 2.38782 16.7499C2.0992 15.4512 2 13.8757 2 12C2 10.1243 2.0992 8.54878 2.38782 7.25007C2.67897 5.94002 3.176 4.85116 4.01358 4.01358C4.85116 3.176 5.94002 2.67897 7.25007 2.38782ZM9 11.5C9 10.1193 10.1193 9 11.5 9C12.8807 9 14 10.1193 14 11.5C14 12.8807 12.8807 14 11.5 14C10.1193 14 9 12.8807 9 11.5ZM11.5 7C9.01472 7 7 9.01472 7 11.5C7 13.9853 9.01472 16 11.5 16C12.3805 16 13.202 15.7471 13.8957 15.31L15.2929 16.7071C15.6834 17.0976 16.3166 17.0976 16.7071 16.7071C17.0976 16.3166 17.0976 15.6834 16.7071 15.2929L15.31 13.8957C15.7471 13.202 16 12.3805 16 11.5C16 9.01472 13.9853 7 11.5 7Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
  </div>
            </div>
        </div>
    </nav>
</header>
<section class="home-section">
  <img src="images/stars.png">
  <img src="images/mountains_back.png" alt="Mountains back" id="mountains_back">
    <div class="container">
        <div class="content">
            <h1>Contact Us</h1>

            <div class="contact-container">
                <div class="contact-info">
                    <i class="icon fas fa-map-marker-alt"></i>
                    <span>Dolores Municipal Hall, Barangay Bulakin II, Dolores, Philippines</span>
                </div>
                <div class="contact-info">
                    <i class="icon fas fa-phone"></i>
                    <span>(042) 565 6331</span>
                </div>
                <div class="contact-info">
                    <i class="icon fas fa-envelope"></i>
                    <span><a href="mailto:lgudoloresquezon@yahoo.com">lgudoloresquezon@yahoo.com</a></span>
                </div>
                <div class="contact-info">
                    <i class="icon fas fa-globe"></i>
                    <span><a href="http://dolores.quezon.gov.ph" target="_blank">dolores.quezon.gov.ph</a></span>
                </div>
            </div>
        </div>
    </div>
    </section>
</body>
</html>
