@extends('master')

@section('content')
    <fieldset class="developer_quote">
        <legend>
            <i class="fa fa-quote-left"></i>
        </legend>

        <P>
            Our primary goal is to provide an <em>easier</em> and more <em>affordable</em> experience
            for all <span class="ut_yellow">University</span> of <span class="ut_blue">Toledo</span>
            students. This website is for <span class="ut_yellow">U</span><span class="ut_blue">T</span>
            students only and it comes at no cost at all. Why sell your books for
            a low price to book stores and let them sell your books back to your friends
            for a lot more?!
        </P>

        <span>-- Developer team</span>
    </fieldset>
@endsection

@section('style')
    <style>
        fieldset.developer_quote{
            margin: 1rem auto;
            width: 40%;
            max-width: 43.75rem;
            min-width: 23rem;
            padding: 0 0.9rem 0.9rem 0.9rem;
            border: 0.09rem dashed #666666;
            border-radius: 0.9rem;
        }

        fieldset.developer_quote p{
            margin: 0 1rem 0 1rem;
        }

        i.fa-quote-left{
            font-size: 2rem;
            color: #444444;
            margin: 0 0.3125rem 0 0.3125rem;
        }

        fieldset.developer_quote > span{
            float: right;
            font-weight: lighter;
            font-style: italic;
            font-size: 0.85rem;
        }
    </style>
@endsection