<template>
  <q-page class="flex flex-center">
    <div class="col-md-8">
      <q-card>
        <q-card-section>
          <div class="text-h6">{{ __('Dashboard') }}</div>
        </q-card-section>
        
        <q-card-section>
          @if (session('status'))
            <q-alert color="positive">{{ session('status') }}</q-alert>
          @endif

          {{ __('You are logged in!') }}
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script>
export default {
  name: 'Home',
}
</script>
