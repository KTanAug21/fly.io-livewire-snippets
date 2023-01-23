
<div id="showFileComponent" wire:init="allowFileLoading">
   @if( $loadAllowed==true  )
      <iframe id="myIframe" class="w-full border-8" src="{{ URL::to('/documents/display/'.$recordId ) }}"></iframe>
   @else
      Loading PDF
   @endif
</div>