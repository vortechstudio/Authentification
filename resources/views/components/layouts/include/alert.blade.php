@if(session()->has('success'))
    <x-base.alert
        type="success"
        icon="fa-solid fa-check-circle"
        title="Succès"
        :content="session()->get('success')" />
@endif

@if(session()->has('warning'))
    <x-base.alert
        type="warning"
        icon="fa-solid fa-exclamation-triangle"
        title="Attention"
        :content="session()->get('success')" />
@endif

@if(session()->has('error'))
    <x-base.alert
        type="danger"
        icon="fa-solid fa-xmark-circle"
        title="Erreur"
        :content="session()->get('error')" />
@endif

@if(session()->has('info'))
    <x-base.alert
        type="info"
        icon="fa-solid fa-info-circle"
        title="Information"
        :content="session()->get('info')" />
@endif

@if(session()->has('message'))
    <x-base.alert
        type="secondary"
        icon="fa-solid fa-info-circle"
        title="Message"
        :content="session()->get('message')" />
@endif
