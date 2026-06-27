@extends('layout.master')

@section('title', 'About Us — Apon-Industries')


@section('content')

<main class="main single-page">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}" rel="nofollow">Home</a>
                <span></span> About us
            </div>
        </div>
    </div>
    <section class="section-padding">
        <div class="container pt-25">
            <div class="row">
                <div class="col-lg-6 align-self-center mb-lg-0 mb-4">
                    <h6 class="mt-0 mb-15 text-uppercase font-sm text-brand wow fadeIn animated">Apon Plastic Industries
                    </h6>
                    <h1 class="font-heading mb-40">
                        Creating complex products from concept to completion
                    </h1>
                    <p>Established in Bangladesh in 2016, Apon Plastic Industries is our latest venture,
                        showcasing our ongoing commitment to innovation and excellence in the plastic industry.
                        Founded under the guidance of our esteemed Chairman, who brings more than 38 years of
                        experience and expertise in injection molding, we're dedicated to delivering high-quality
                        plastic solutions to meet the evolving needs of modern industries. .</p>
                    <p>Our focus on quality and customer satisfaction is the driving force imparted to
                        us by our founder, ensuring that every product that bears the Apon Plastic Industries
                        name reflects our unwavering commitment to excellence. We continuously strive to
                        exceed customer expectations, not just in the products we deliver, but also in the
                        level of service and support we provide. </p>
                    <p>
                        Not sure which manufacturing process is best for your complex molded component?
                        Let us handle it. We can advise you on the best molding process for your project
                        based on your product design, performance requirements, and budget.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="assets/imgs/page/about-1.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="testimonials" class="section-padding">
        <div class="container pt-25">
            <div class="row mb-50">
                <div class="col-lg-12 col-md-12 text-center">
                    <h6 class="mt-0 mb-10 text-uppercase  text-brand font-sm wow fadeIn animated">some facts</h6>
                    <h2 class="mb-15 text-grey-1 wow fadeIn animated">Take a look on<br> Company Management</h2>

                </div>
            </div>
            <div class="row">

                {{-- Chairman --}}
                <div class="col-md-6 col-lg-4 mb-30">
                    <div class="wow fadeIn animated hover-up h-100" style="background:#fff;border-radius:14px;box-shadow:0 6px 24px rgba(0,0,0,.07);padding:24px;">
                        <div class="d-flex align-items-center mb-15">
                            <img src="{{ asset('assets/uploads/About Us/Anisuz ZamanChairman.png') }}"
                                 alt="Anisuz Zaman"
                                 style="width:150px;height:150px;object-fit:cover;border-radius:10px;flex-shrink:0;">
                            <div style="padding-left:16px;">
                                <h5 class="mb-2 fw-500" style="color:#253d4e;">Anisuz Zaman</h5>
                                <p class="font-sm mb-0" style="color:#f15412;font-weight:600;">Chairman</p>
                            </div>
                        </div>
                        <p class="text-grey-3 mb-0" style="text-align:justify;font-size:14px;line-height:1.7;">
                            With over 39 years of experience, our Chairman is a seasoned leader in the industry,
                            known for his expertise and dedication. His pivotal role in establishing Apon Plastic's
                            reputation for excellence speaks volumes about his commitment to quality and innovation.
                        </p>
                    </div>
                </div>

                {{-- Managing Director --}}
                <div class="col-md-6 col-lg-4 mb-30">
                    <div class="wow fadeIn animated hover-up h-100" style="background:#fff;border-radius:14px;box-shadow:0 6px 24px rgba(0,0,0,.07);padding:24px;">
                        <div class="d-flex align-items-center mb-15">
                            <img src="{{ asset('assets/uploads/About Us/Paul ZamanManaging Director.png') }}"
                                 alt="Paul Zaman"
                                 style="width:150px;height:150px;object-fit:cover;border-radius:10px;flex-shrink:0;">
                            <div style="padding-left:16px;">
                                <h5 class="mb-2 fw-500" style="color:#253d4e;">Paul Zaman</h5>
                                <p class="font-sm mb-0" style="color:#f15412;font-weight:600;">Managing Director</p>
                            </div>
                        </div>
                        <p class="text-grey-3 mb-0" style="text-align:justify;font-size:14px;line-height:1.7;">
                            Our Managing Director, the son of our esteemed Chairman, brings a fresh perspective
                            and dedication to our company. Having learned the intricacies of injection molding
                            and plastics directly from the Chairman, coupled with the completion of RJG courses,
                            he's equipped with a solid foundation.
                        </p>
                    </div>
                </div>

                {{-- Sales & Marketing Manager --}}
                <div class="col-md-6 col-lg-4 mb-30">
                    <div class="wow fadeIn animated hover-up h-100" style="background:#fff;border-radius:14px;box-shadow:0 6px 24px rgba(0,0,0,.07);padding:24px;">
                        <div class="d-flex align-items-center mb-15">
                            <img src="{{ asset('assets/uploads/About Us/Maruf HassanSales and Marketing Manager.png') }}"
                                 alt="Maruf Hassan"
                                 style="width:150px;height:150px;object-fit:cover;border-radius:10px;flex-shrink:0;">
                            <div style="padding-left:16px;">
                                <h5 class="mb-2 fw-500" style="color:#253d4e;">Maruf Hassan</h5>
                                <p class="font-sm mb-0" style="color:#f15412;font-weight:600;">Sales and Marketing Manager</p>
                            </div>
                        </div>
                        <p class="text-grey-3 mb-0" style="text-align:justify;font-size:14px;line-height:1.7;">
                            Mr. Maruf Hassan's expertise has been pivotal in driving our growth and development
                            here in Bangladesh. With over 7 years of specialized experience in Sales and a total
                            of 10 years immersed in the plastic sector, Mr. Maruf brings a wealth of industry
                            knowledge to our team.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>
@endsection
