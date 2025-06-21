<div>
  <input x-data="mask{{ $id }}('{{ $id }}', '{{ $currencySign }}')" x-on:money-input-updated.window="if($event.detail.id == '{{ $id }}'){ setValue(); }" class="money-input" placeholder="{{ $placeholder }}" x-on:blur="getValue()" id="{{ $id }}" name="{{ $name }}" type="text" @if($required) required @endif @if($disabled) disabled @endif />
  @script
  <script>
    Alpine.data('mask{{ $id }}', (inputId, currencySign) => ({
      inputElement: document.getElementById(inputId),
      inputMask: null,
      init() {
        this.inputMask = IMask(
          this.inputElement,
          {
            mask: currencySign + 'num',
            blocks: {
              num: {
                mask: Number,
                scale: 2,
                padFractionalZeros: true,
                thousandsSeparator: '.',
                radix: ',',
                mapToRadix: ['.'],
                min: 100000,
                max: 1000000000
              }
            }
          }
        );
        this.setValue();
        this.inputMask.updateValue();
      },
      getValue() {
        $wire.unmaskedValue = this.inputMask.unmaskedValue;
      },
      setValue() {
        this.inputMask.unmaskedValue = $wire.unmaskedValue + "";
        this.inputMask.updateValue();
      }
    }));
  </script>
  @endscript
</div>