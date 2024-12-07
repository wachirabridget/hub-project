from django.shortcuts import render

# Create your views here.
def harvesthub(request):
    return render(request, 'harvesthub.html')
