# yii2-bootstrap-tags

Yii2 widget-wrapper for [bootstrap-tags](https://github.com/maxwells/bootstrap-tags) bootstrap widget
with one enhencemets: it renders and updates hidden input with tags (in string separated by [[separator]])
so it can be sent with form

It uses [[separator]] to separate tags in hidden input and also for adding
multiple tags simultaneously when user type several values separated by
[[separator]] and hits enter

As any InputWidget can use ( [[model]] and [[attribute]] ) or ( [[name]] and [[value]] )

If you dont want hidden input with value and extra js code connected to it,
just set [[useHiddenInput]] to false

## Usage

It can be used as separate widget:
```php
   <?= BootstrapTags::widget([
       'name' => 'some-name',
       'value' => 'tag1, tag2, tag3',
       // 'useHiddenInput' => false,
   ]) ?> 
```
or
```php
   <?= BootstrapTags::widget([
       'model' => $model,
       'attribute' => 'some-attribute',
       // 'useHiddenInput' => false,
   ]) ?> 
```
or
```php
    <?= $form->field($model, 'some-attribute')->widget(BootstrapTags::className(), []) ?>
```
