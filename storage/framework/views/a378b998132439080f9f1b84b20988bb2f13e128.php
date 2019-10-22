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
                <a href="<?php echo e(route('backstage.published-concert-orders.index', $concert)); ?>" class="btn-inline bold mg-right-sm">Orders</a>
                <a href="<?php echo e(route('backstage.concert-messages.new', $concert)); ?>" class="btn-inline">Message Attendees</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="message-box">
            <div class="message-card">
                <h1 class="list-title text-center">New Message</h1>
                
                <?php if(session('flash')): ?>
                <div class="alert alert--success">Message sent!</div>
                <?php endif; ?>
                <form class="form block" action="<?php echo e(route('backstage.concert-messages.store', $concert)); ?>" method="POST">
                <?php echo e(csrf_field()); ?>

                    <div class="form-group mg-bottom-sm <?php echo e($errors->first('subject', 'has-error')); ?>">
                        <label class="form__label">Subject</label>
                        <input type="text" class="form__control" name="subject" value="<?php echo e(old('subject')); ?>">
                        <?php if($errors->has('subject')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('subject')); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mg-bottom-sm <?php echo e($errors->first('message', 'has-error')); ?>">
                        <label class="form__label">Message</label>
                        <textarea name="message" rows="10" class="form__control" value="<?php echo e(old('message')); ?>"></textarea>
                        <?php if($errors->has('message')): ?>
                        <p class="help-block">
                            <?php echo e($errors->first('message')); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="text-center">
                        <button class="btn btn--normal" type="submit">Send Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backstage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\ticket_booking\resources\views/backstage/concert-messages/new.blade.php ENDPATH**/ ?>