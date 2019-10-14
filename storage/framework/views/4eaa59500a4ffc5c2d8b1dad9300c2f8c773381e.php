
<div class="concert">
    <div class="concert__container">
        <div class="heading-primary mg-bottom-md">
            <h1 class="heading-primary--main"><?php echo e($concert->title); ?></h1>
            <h2 class="heading-primary--sub"><?php echo e($concert->subtitle); ?></h2>
        </div>
        <ul class="concert__info">
            <li class="concert__info__item">
                <img src='<?php echo e(asset("images/calendar.svg")); ?>' alt="calendar icon">
                <span><?php echo e($concert->formatted_date); ?></span>
            </li>
            <li class="concert__info__item">
                <img src='<?php echo e(asset("images/time.svg")); ?>' alt="time icon">
                <span><?php echo e($concert->formatted_start_time); ?></span>
            </li>
            <li class="concert__info__item">
                <img src='<?php echo e(asset("images/currency-dollar.svg")); ?>' alt="currency-dollar icon">
                <span><?php echo e($concert->ticket_price_in_dollars); ?></span>
            </li>
            <li class="concert__info__item">
                <img src='<?php echo e(asset("images/location.svg")); ?>' alt="location icon">
                <span><?php echo e($concert->venue); ?></span>
                <p><?php echo e($concert->venue_address); ?> <?php echo e($concert->city); ?>, <?php echo e($concert->state); ?> <?php echo e($concert->zip); ?></p>
                
            </li>
            <li class="concert__info__item">
                <img src='<?php echo e(asset("images/information-outline.svg")); ?>' alt="information icon">
                <span>Additonal Information</span>
                <p><?php echo e($concert->additional_information); ?></p>				
            </li>
        </ul>
    </div>
    <div class="cta">
        <ticket-checkout
            concert-id="<?php echo e($concert->id); ?>" 
            concert-title="<?php echo e($concert->title); ?>"
            price="<?php echo e($concert->ticket_price); ?>"
        ></ticket-checkout>
    </div>
</div><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/concerts/partials/card-no-poster.blade.php ENDPATH**/ ?>