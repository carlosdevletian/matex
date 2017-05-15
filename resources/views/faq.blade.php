@extends('layouts.app')

@section('title')
    Frequently Asked Questions
@endsection

@section('content')
	<div class="container">
        <div class="row Section">
            <div class="col-xs-10 col-xs-offset-1">
                <h3 class="main-title text-center">Frequently Asked Questions</h3>
                <faq inline-template v-cloak>
                    <div>
                        <div class="Card position-relative" @click="select($event)" style="cursor: pointer;">
                            <div class="Card__title" style="pointer-events: none;">
                                What is Your Refund Policy?
                            </div>
                            <div class="Card__body">
                                We currently do not offer refunds
                            </div>
                        </div>
                        <div class="Card" @click="select($event)" style="cursor: pointer">
                            <div class="Card__title" style="pointer-events: none;">
                                How are your prices calculated?
                            </div>
                            <div class="Card__body">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas, dolorum. Rem ducimus id sunt quas laudantium. Quis placeat magni a delectus rem nesciunt fugit, nihil velit obcaecati perspiciatis. Sapiente, quis!
                            </div>
                        </div>
                        <div class="Card" @click="select($event)" style="cursor: pointer">
                            <div class="Card__title" style="pointer-events: none;">
                                Where do you operate?
                            </div>
                            <div class="Card__body">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus quae reprehenderit consectetur laborum facilis fugit alias id, saepe architecto minus numquam dolorum cum aut incidunt enim, labore, atque quam accusamus.
                            </div>
                        </div>
                    </div>
                </faq>
            </div>
        </div>
    </div>
@endsection
