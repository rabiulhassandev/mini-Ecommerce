<x-front-layout>
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{ route('home.index') }}" class="link">হোম</a></li>
                <li class="item-link"><span>যোগাযোগ</span></li>
            </ul>
        </div>
        <div class="row" style="padding-bottom: 50px;">
            <div class=" main-content-area">
                {{-- <div class="wrap-contacts ">
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="contact-box contact-form">
                            <h2 class="box-title">Leave a Message</h2>
                            <form action="#" method="get" name="frm-contact">

                                <label for="name">Name<span>*</span></label>
                                <input type="text" value="" id="name" name="name" >

                                <label for="email">Email<span>*</span></label>
                                <input type="text" value="" id="email" name="email" >

                                <label for="phone">Number Phone</label>
                                <input type="text" value="" id="phone" name="phone" >

                                <label for="comment">Comment</label>
                                <textarea name="comment" id="comment"></textarea>

                                <input type="submit" name="ok" value="Submit" >

                            </form>
                        </div>
                    </div> --}}
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="wrap-map">
                            <iframe src="{{ setting('contact.map') }}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="contact-box contact-info">
                            <h2 class="box-title">যোগাযোগ তথ্য</h2>
                            <div class="wrap-icon-box">

                                <div class="icon-box-item">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <div class="right-info">
                                        <b>ই-মেইল</b>
                                        <p>{{ setting('contact.email') }}</p>
                                    </div>
                                </div>

                                <div class="icon-box-item">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <div class="right-info">
                                        <b>ফোন নাম্বার</b>
                                        <p>{{ en2bn(setting('contact.hotline')) }}, {{ en2bn(setting('contact.hotline2')) }}, </p>
                                    </div>
                                </div>

                                <div class="icon-box-item">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <div class="right-info">
                                        <b>ঠিকানা</b>
                                        <p>{{ setting('contact.address') }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end main products area-->

        </div><!--end row-->

    </div><!--end container-->
</x-front-layout>
