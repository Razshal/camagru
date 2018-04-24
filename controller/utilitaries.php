<?php

function hash_pw($pw)
{
    return hash($pw, "SHA512");
}