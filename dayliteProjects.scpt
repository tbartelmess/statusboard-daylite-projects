FasdUAS 1.101.10   ��   ��    k             l    
 ����  O     
  	  I   	�� 
��
�� .misceval****       obj  
 m       �  d 
 	 p r o j e c t s   : =   { } . 
 w i t h D u e D a t e s   : =   o b j e c t C o n t e x t   o b j e c t s F o r E n t i t y N a m e d : ' P r o j e c t '   
 	 q u a l i f i e r L o c u m : ' ( s t a t u s C o d e   = =   0   O R   s t a t u s C o d e   = =   4 )   A N D   d u e D a t e   ! =   n i l '   b i n d i n g s : n i l . 
 s o r t e d   : =   w i t h D u e D a t e s   s o r t e d A r r a y U s i n g D e s c r i p t o r s : { ( N S S o r t D e s c r i p t o r   s o r t D e s c r i p t o r W i t h K e y : ' d u e D a t e '     a s c e n d i n g : t r u e ) } . 
 p r o j e c t s   a d d O b j e c t s F r o m A r r a y : s o r t e d . 
 
 w i t h o u t D u e D a t e s   : =   o b j e c t C o n t e x t   o b j e c t s F o r E n t i t y N a m e d : ' P r o j e c t '   q u a l i f i e r L o c u m : ' ( s t a t u s C o d e   = =   0   O R   s t a t u s C o d e   = =   4 )   A N D   d u e D a t e   = =   n i l '   b i n d i n g s : n i l . 
 	 
 p r o j e c t s   a d d O b j e c t s F r o m A r r a y : w i t h o u t D u e D a t e s . 
 
 
 a r r a y   : =   { } . 
 p r o j e c t s   d o : [ : p r o j e c t   | 
 	 d i c t   : =   # { } . 
 	 d i c t   s e t O b j e c t : ( p r o j e c t   n a m e )   f o r K e y : ' p r o j e c t N a m e '   d e f a u l t O b j e c t : ' N o   n a m e ' . 	 
 	 d i c t   s e t O b j e c t : ( ( p r o j e c t   d u e D a t e )   m c M e d i u m D a t e )   f o r K e y : ' d u e D a t e '   d e f a u l t O b j e c t : ' N o   d a t e ' . 	 
 	 d i c t   s e t O b j e c t : ( ( ( p r o j e c t   c u r r e n t P i p e l i n e S t a g e )   p i p e l i n e S t a g e D e f i n i t i o n )   n a m e )   f o r K e y : ' s t a g e '   d e f a u l t O b j e c t : ' N o   s t a g e ' . 
 	 d i c t   s e t O b j e c t : ( ( p r o j e c t   c a t e g o r y )   n a m e )   f o r K e y : ' c a t e g o r y '   d e f a u l t O b j e c t : ' N o   c a t e g o r y ' . 
 	 d i c t   s e t O b j e c t : ( ( ( p r o j e c t   a s s i g n e d T o )   c o n t a c t )   c a c h e d N a m e )   f o r K e y : ' o w n e r '   d e f a u l t O b j e c t : ' N o   o w n e r ' . 
 	 d i c t   s e t O b j e c t : ( p r o j e c t   l e v e l )   f o r K e y : ' p r i o r i t y '   d e f a u l t O b j e c t : 0 . 
 	     	 t o t a l S t a g e s   : =   ( ( ( ( p r o j e c t   c u r r e n t P i p e l i n e )   p i p e l i n e D e f i n i t i o n )   p i p e l i n e S t a g e D e f i n i t i o n s )   c o u n t ) . 
 	 c u r r e n t S t a g e   : =   ( ( ( p r o j e c t   c u r r e n t P i p e l i n e S t a g e )   p i p e l i n e S t a g e D e f i n i t i o n )   o r d e r ) . 
 	 p e r c e n t D o n e   : =   ( c u r r e n t S t a g e   /   t o t a l S t a g e s )   *   1 0 0 . 
 	 p e r c e n t D o n e S t r i n g   : =   ( p e r c e n t D o n e   s t r i n g V a l u e )   + +   ' % ' . 
 
 	 d i c t   s e t O b j e c t : t o t a l S t a g e s   f o r K e y : ' t o t a l S t a g e s '   d e f a u l t O b j e c t : 0 . 
 	 d i c t   s e t O b j e c t : c u r r e n t S t a g e   f o r K e y : ' c u r r e n t S t a g e '   d e f a u l t O b j e c t : 0 . 
 	 d i c t   s e t O b j e c t : p e r c e n t D o n e S t r i n g   f o r K e y : ' p e r c e n t D o n e S t r i n g '   d e f a u l t O b j e c t : ' ~ ' . 
 	 
 	 c l i e n t Q u a l i f i e r   : =   B D Q u a l i f i e r   q u a l i f i e r W i t h L o c u m : ' r o l e T y p e . n a m e   = =   $ r o l e N a m e '   b i n d i n g s : # { ' r o l e N a m e '   - >   ' C l i e n t ' } . 
 	 c l i e n t   : =   ( ( ( ( p r o j e c t   r o l e s )   f i l t e r e d A r r a y U s i n g Q u a l i f i e r : c l i e n t Q u a l i f i e r )   l a s t O b j e c t )   c o n t a c t ) . 
 	 d i c t   s e t O b j e c t : ( c l i e n t   c a c h e d N a m e )   f o r K e y : ' c l i e n t '   d e f a u l t O b j e c t : ' N o   c l i e n t ' . 
 	 d i c t   s e t O b j e c t : ( c l i e n t   c a c h e d D e f a u l t O r g a n i z a t i o n N a m e )   f o r K e y : ' c o m p a n y '   d e f a u l t O b j e c t : ' N o   c o m p a n y ' . 
 
 	 a r r a y   a d d : d i c t . 
 ] . 
 
 j s o n S t r i n g   : =   a r r a y   J S O N R e p r e s e n t a t i o n . 
 
 r e q   : =   A S I H T T P R e q u e s t   r e q u e s t W i t h U R L : ( N S U R L   U R L W i t h S t r i n g : ' h t t p : / / w w w . d o m a i n . c o m / d a y l i t e P r o j e c t s . p h p ? l o a d ' ) . 
 	 
 r e q   s e t R e q u e s t M e t h o d : ' P O S T ' . 
 r e q   s e t T i m e O u t S e c o n d s : 6 0 . 0 . 
 r e q   s e t N u m b e r O f T i m e s T o R e t r y O n T i m e o u t : 3 . 
 
 r e q   b u i l d R e q u e s t H e a d e r s . 
 r e q   a d d R e q u e s t H e a d e r : ' C o n t e n t - T y p e '   v a l u e : ' a p p l i c a t i o n / j s o n ' . 
 r e q   s e t P o s t B o d y : ( j s o n S t r i n g   d a t a U s i n g E n c o d i n g : N S U T F 8 S t r i n g E n c o d i n g ) . 
 r e q   s t a r t S y n c h r o n o u s . 
 	��   	 m       �                                                                                      @ alis    6  Mac                        �9uH+  ���Daylite.app                                                    ޼P�uy        ����  	                Applications    �9X�      �uk    ���  Mac:Applications: Daylite.app     D a y l i t e . a p p    M a c  Applications/Daylite.app  / ��  ��  ��     ��  l     ��������  ��  ��  ��       ��  ��    ��
�� .aevtoappnull  �   � ****  �� ����  ��
�� .aevtoappnull  �   � ****  k     
    ����  ��  ��         ��
�� .misceval****       obj �� � �j Uascr  ��ޭ