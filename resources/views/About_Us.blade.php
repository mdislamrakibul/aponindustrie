@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')

<main class="main single-page">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow">Home</a>
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
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="hero-card box-shadow-outer-6 wow fadeIn animated mb-30 hover-up d-flex">
                        <div class="hero-card-icon icon-left-2 hover-up ">
                            <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted"
                                src="{{ asset('assets/uploads/About Us/Anisuz ZamanChairman.png') }}"
                                alt="">

                            {{-- <img class="animated slider-1-1"
                                src="{{ asset('assets/uploads/Main Slider Design/Main Slider Design-2-Apon Plastic.png') }}"
                                alt=""> --}}
                        </div>
                        <div class="pl-30">
                            <h5 class="mb-5 fw-500">
                                Anisuz Zaman
                            </h5>
                            <p class="font-sm text-grey-5">Chairman</p>
                            <p class="text-grey-3" style="text-align: justify">With over 39 years of experience, our
                                Chairman is a seasoned
                                leader in the industry, known for his expertise and dedication. His pivotal
                                role in establishing Apon Plastic's reputation for excellence speaks volumes
                                about his commitment to quality and innovation.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="hero-card box-shadow-outer-6 wow fadeIn animated mb-30 hover-up d-flex">
                        <div class="hero-card-icon icon-left-2 hover-up ">
                            <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted"
                                src="{{ asset('assets/uploads/About Us/Paul ZamanManaging Director.png') }}"
                                alt="">
                        </div>
                        <div class="pl-30">
                            <h5 class="mb-5 fw-500">
                                Paul Zaman
                            </h5>
                            <p class="font-sm text-grey-5">Managing Director</p>
                            <p class="text-grey-3" style="text-align: justify">Our Managing Director, the son of our
                                esteemed Chairman,
                                brings a fresh perspective and dedication to our company. Having learned
                                the intricacies of injection molding and plastics directly from the Chairman,
                                coupled with the completion of RJG courses, he's equipped with a solid
                                foundation.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="hero-card box-shadow-outer-6 wow fadeIn animated mb-30 hover-up d-flex">
                        <div class="hero-card-icon icon-left-2 hover-up ">
                            <img class="btn-shadow-brand hover-up border-radius-5 bg-brand-muted"
                                src="{{ asset('assets/uploads/About Us/Maruf HassanSales and Marketing Manager.png') }}"
                                alt="">
                        </div>
                        <div class="pl-30">
                            <h5 class="mb-5 fw-500">
                                Maruf Hassan

                            </h5>
                            <p class="font-sm text-grey-5">Sales and Marketing Manager</p>
                            <p class="text-grey-3" style="text-align: justify">Mr. Maruf Hassan's expertise has been
                                pivotal in driving
                                our growth and development here in Bangladesh. With over 7 years of specialized
                                experience in Sales and
                                a total of 10 years immersed in the plastic sector, Mr. Maruf brings a wealth of
                                industry knowledge to
                                our team.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>
@endsection
