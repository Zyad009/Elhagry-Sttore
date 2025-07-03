@extends('front.layouts.app')
@section("front-title", "Contact Us")
@section("front-content")
<main class="main">

  <div class="mb-2"></div><!-- End .mb-2 -->
  <div class="container">
    <h1 class="page-title text-dark">Contact us Page</h1>
  </div><!-- End .container -->
  <div class="mb-2"></div><!-- End .mb-2 -->

  <div class="page-content pb-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mb-2 mb-lg-0">
          <h2 class="title mb-1">Contact Information</h2><!-- End .title mb-2 -->
          <p class="mb-3">Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien
            ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
          <div class="row">
            <div class="col-sm-7">
              <div class="contact-info">
                {{-- الرفع الرئيسي --}}
                <h3>Alexandria</h3>
                <ul class="contact-list">
                  <li>
                    <i class="icon-map-marker"></i>
                    70 Washington Square South New York, NY 10012, United States
                  </li>
                  <li>
                    <i class="icon-phone"></i>
                    <a href="tel:#">+92 423 567</a>
                  </li>
                  <li>
                    <i class="icon-envelope"></i>
                    <a href="mailto:#">info@Molla.com</a>
                  </li>
                </ul><!-- End .contact-list -->
              </div><!-- End .contact-info -->
            </div><!-- End .col-sm-7 -->

            <div class="col-sm-5">
              <div class="contact-info">
                <h3>Openning</h3>

                <ul class="contact-list">
                  <li>
                    <i class="icon-clock-o"></i>
                    <span class="text-dark">Monday-Saturday</span> <br>11am-7pm ET
                  </li>
                  <li>
                    <i class="icon-calendar"></i>
                    <span class="text-dark">Sunday</span> <br>11am-6pm ET
                  </li>
                </ul><!-- End .contact-list -->
              </div><!-- End .contact-info -->
            </div><!-- End .col-sm-5 -->
          </div><!-- End .row -->
        </div><!-- End .col-lg-6 -->

        {{-- الرسائل --}}
        <div class="col-lg-6">
          <h2 class="title mb-1">Got Any Questions?</h2><!-- End .title mb-2 -->
          <p class="mb-2">Use the form below to get in touch with the sales team</p>

          <form action="{{route('contact.store')}}" method="POST" novalidate class="contact-form mb-3 needs-validation">
            @csrf
            <div class="row">
              <div class="col-sm-6">
                <label for="cname">Name <span class="text-danger">*</span>
                  <x-message.error name="name" />
                </label>

                <input type="text" class="form-control" name="name" value="{{old('name')}}" id="cname"
                  placeholder="Name" required>

              </div><!-- End .col-sm-6 -->

              <div class="col-sm-6">
                <label for="cemail">Email <span class="text-danger">*</span>
                  <x-message.error name="email" />
                </label>
                <input type="email" class="form-control" name="email" value="{{old('email')}}" id="cemail"
                  placeholder="Email" required>
              </div><!-- End .col-sm-6 -->
            </div><!-- End .row -->

            <div class="row">
              <div class="col-sm-6">
                <label for="cphone">Phone <span class="text-danger">*</span>
                  <x-message.error name="phone" />
                </label>
                <input type="tel" class="form-control" name="phone" value="{{old('phone')}}" id="cphone"
                  placeholder="Phone">
              </div><!-- End .col-sm-6 -->

              <div class="col-sm-6">
                <label for="csubject">Subject <span class="text-danger">*</span>
                  <x-message.error name="subject" />
                </label>
                <input type="text" class="form-control" name="subject" value="{{old('subject')}}" id="csubject"
                  placeholder="Subject">
              </div><!-- End .col-sm-6 -->
            </div><!-- End .row -->

            <label for="cmessage">Message <span class="text-danger">*</span>
              <x-message.error name="message" />
            </label>
            <textarea class="form-control" cols="30" name="message" rows="4" id="cmessage" required
              placeholder="Message">{{old('message')}}</textarea>


            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
              <span>SUBMIT</span>
              <i class="icon-long-arrow-right"></i>
            </button>
          </form><!-- End .contact-form -->
        </div><!-- End .col-lg-6 -->
      </div><!-- End .row -->

      <hr class="mt-4 mb-5">

      <div class="stores mb-4 mb-lg-5">
        <h2 class="title text-center mb-3">Our Stores</h2><!-- End .title text-center mb-2 -->

        <div class="row">
          <div class="col-lg-6">
            <div class="store">
              <div class="row">
                <div class="col-sm-5 col-xl-6">
                </div><!-- End .col-xl-6 -->
                <div class="col-sm-7 col-xl-6">
                  <div class="store-content">
                    <h3 class="store-title">Wall Street Plaza</h3><!-- End .store-title -->
                    <address>88 Pine St, New York, NY 10005, USA</address>
                    <div><a href="tel:#">+1 987-876-6543</a></div>

                    <h4 class="store-subtitle">Store Hours:</h4><!-- End .store-subtitle -->
                    <div>Monday - Saturday 11am to 7pm</div>
                    <div>Sunday 11am to 6pm</div>
                  </div><!-- End .store-content -->
                </div><!-- End .col-xl-6 -->
              </div><!-- End .row -->
            </div><!-- End .store -->
          </div><!-- End .col-lg-6 -->
        </div><!-- End .row -->
      </div><!-- End .stores -->
    </div><!-- End .container -->
  </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection