<x-front-layout>
    <div class="container py-5">
        <div class="row py-2 contact-section">
            <p class="lead">Find US</p>
            <div class="col-12 col-md-6">
               <iframe src="{{ setting('contact.map') }}"
                  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col col-md-6 mt-3 mt-md-0">
               <h4 class="mb-3">Conatact Information</h4>
               <div class="d-flex align-items-center mb-3">
                  <div class="me-4 contact-icon" style="background: #273153;"><i class="fa-solid text-white fa-envelope"
                        style="font-size: 22px;"></i>
                  </div>
                  <div>
                     <p class="m-0 p-0 fw-semibold">Email</p>
                     <p class="m-0 p-0">{{ setting('contact.email') }}</p>
                  </div>
               </div>
               <div class="d-flex align-items-center mb-3">
                  <div class="me-4 contact-icon" style="background: #273153;"><i class="text-white fa-brands fa-whatsapp"
                        style="font-size: 22px;"></i>
                  </div>
                  <div>
                     <p class="m-0 p-0 fw-semibold">WhatsApp</p>
                     <p class="m-0 p-0">{{ setting('contact.whatsapp') }}</p>
                  </div>
               </div>
               <div class="d-flex align-items-center mb-3">
                  <div class="me-4 contact-icon" style="background: #273153;"><i
                        class="fa-solid fa-location-dot text-white" style="font-size: 24px;"></i>
                  </div>
                  <div>
                     <p class="m-0 p-0 fw-semibold">Location</p>
                     <p class="m-0 p-0">{{ setting('contact.address') }}</p>
                  </div>
               </div>
            </div>
         </div>
    </div>

    @push('extra-styles')
        <link rel="stylesheet" href="{{ front_asset('css/contact.min.css') }}">
    @endpush
</x-front-layout>