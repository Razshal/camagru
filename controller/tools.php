<?php

function hash_pw($pw)
{
    return hash("SHA512", $pw);
}