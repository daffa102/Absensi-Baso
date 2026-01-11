import os
import re

def check_blade_balance(directory):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if file.endswith('.blade.php'):
                path = os.path.join(root, file)
                with open(path, 'r', encoding='utf-8') as f:
                    content = f.read()
                    
                    # Check @if/@endif
                    ifs = len(re.findall(r'@if\b', content))
                    endifs = len(re.findall(r'@endif\b', content))
                    
                    # Check @foreach/@endforeach
                    foreachs = len(re.findall(r'@foreach\b', content))
                    endforeachs = len(re.findall(r'@endforeach\b', content))
                    
                    # Check @forelse/@endforelse
                    forelses = len(re.findall(r'@forelse\b', content))
                    endforelses = len(re.findall(r'@endforelse\b', content))
                    
                    # Check @for/@endfor
                    fors = len(re.findall(r'@for\b', content))
                    endfors = len(re.findall(r'@endfor\b', content))
                    
                    # Check @auth/@endauth
                    auths = len(re.findall(r'@auth\b', content))
                    endauths = len(re.findall(r'@endauth\b', content))
                    
                    # Check @guest/@endguest
                    guests = len(re.findall(r'@guest\b', content))
                    endguests = len(re.findall(r'@endguest\b', content))
                    
                    # Check @error/@enderror
                    errors = len(re.findall(r'@error\b', content))
                    enderrors = len(re.findall(r'@enderror\b', content))

                    # Check @isset/@endisset
                    issets = len(re.findall(r'@isset\b', content))
                    endissets = len(re.findall(r'@endisset\b', content))

                    # Check @empty/@endempty (only as block directive)
                    empties = len(re.findall(r'@empty\b', content))
                    # Note: @empty is also used in @forelse, so this check is tricky.
                    # But if used as @empty($var) ... @endempty, it should balance.
                    endempties = len(re.findall(r'@endempty\b', content))

                    issues = []
                    if ifs != endifs: issues.append(f"if: {ifs} vs endif: {endifs}")
                    if foreachs != endforeachs: issues.append(f"foreach: {foreachs} vs endforeach: {endforeachs}")
                    if forelses != endforelses: issues.append(f"forelse: {forelses} vs endforelse: {endforelses}")
                    if fors != endfors: issues.append(f"for: {fors} vs endfor: {endfors}")
                    if auths != endauths: issues.append(f"auth: {auths} vs endauth: {endauths}")
                    if guests != endguests: issues.append(f"guest: {guests} vs endguest: {endguests}")
                    if errors != enderrors: issues.append(f"error: {errors} vs enderror: {enderrors}")
                    if issets != endissets: issues.append(f"isset: {issets} vs endisset: {endissets}")
                    if endempties > 0 and empties < endempties: issues.append(f"empty: {empties} vs endempty: {endempties}")

                    if issues:
                        print(f"{path}:")
                        for issue in issues:
                            print(f"  {issue}")

if __name__ == "__main__":
    check_blade_balance('resources/views')
