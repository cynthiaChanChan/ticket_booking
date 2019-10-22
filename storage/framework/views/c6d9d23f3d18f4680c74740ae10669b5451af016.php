<?php $__env->startSection('backstageContent'); ?>
<div class="flex-fit">
    <div class="backstage-bar">
        <div class="container flex-sb-center">
            <h1>
                <strong><?php echo e($concert->title); ?></strong>
                <span class="slash">/</span>
                <span><?php echo e($concert->formatted_date); ?></span>
            </h1>
            <div class="btns">
                <a href="<?php echo e(route('backstage.published-concert-orders.index', ['id' => $concert->id])); ?>" class="btn-inline bold mg-right-sm">Orders</a>
                <a href="<?php echo e(route('backstage.concert-messages.new', ['id' => $concert->id])); ?>" class="btn-inline">Message Attendees</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class='list-title'>Overview</h2>
        <div class="progress-card">
            <div class="progress-card__section">
                <p class="mg-bottom-sm">This show is <?php echo e($concert->percentSoldOut()); ?>% sold out</p>
                <progress class="progress" value="<?php echo e($concert->ticketsSold()); ?>" max="<?php echo e($concert->totalTickets()); ?>">63.11</progress>
            </div>
            <div class="progress-card__list">
                <div class="progress-card__item">
                    <h3>Total Tickets Remaining</h3>
                    <div class="bold"><?php echo e($concert->ticketsRemaining()); ?></div>
                </div>
                <div class="progress-card__item">
                    <h3>Total Tickets Sold</h3>
                    <div class="bold"><?php echo e($concert->ticketsSold()); ?></div>
                </div>
                <div class="progress-card__item">
                    <h3>Total Revenue</h3>
                    <div class="bold">$<?php echo e($concert->revenueInDollars()); ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mg-bottom-md">
        <h2 class='list-title'>Recent Orders</h2>
        <div class="orders-list">
            <?php if($orders->isEmpty()): ?>
            <div class="text-center">
                No orders yet.
            </div>
            <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Tickets</th>
                        <th>Amount</th>
                        <th class="sm-hide">Card</th>
                        <th class="sm-hide">Purchased</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($order->email); ?></td>
                        <td><?php echo e($order->ticketQuantity()); ?></td>
                        <td><?php echo e(number_format($order->amount / 100, 2)); ?></td>
                        <td class="sm-hide"> 
                            <span>****</span>
                            <?php echo e($order->card_last_four); ?>

                        </td>
                        <td class="sm-hide"><?php echo e($order->created_at->format('M j, Y, g:ia')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backstage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/backstage/published-concert-orders/index.blade.php ENDPATH**/ ?>