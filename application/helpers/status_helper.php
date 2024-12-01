<?php

function generate_status_badge($days_difference) {
    if ($days_difference < 0) {
        return '<span class="badge rounded-pill text-bg-danger">Expired</span>';
    } elseif ($days_difference == 0) {
        return '<span class="badge rounded-pill text-bg-warning">Today expired</span>';
    } elseif ($days_difference == 1) {
        return '<span class="badge rounded-pill text-bg-info">Tomorrow to expired</span>';
    } elseif ($days_difference == 2) {
        return '<span class="badge rounded-pill text-bg-primary">2 days to expired</span>';
    } elseif ($days_difference == 3) {
        return '<span class="badge rounded-pill text-bg-primary">3 days to expired</span>';
    } else {
        return '<span class="badge rounded-pill text-bg-success">Active</span>';
    }
}

